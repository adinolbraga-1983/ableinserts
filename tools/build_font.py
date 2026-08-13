#!/usr/bin/env python3
"""Stage B: build the 'Bem Me Quer' font family (5 weights) from the
glyphs.json manifest produced by extract_glyphs.py.

Pipeline per weight:
  - import authored glyph outlines (A-Z a-z 0-9) from the source vector art
  - import the one authored set of special characters (shared across weights)
  - procedurally draw the 6 PT-BR diacritic marks + basic punctuation, sized
    to that weight's stroke proportions
  - compose 26 precomposed accented letters (base + mark)
  - emit TTF / OTF / WOFF / WOFF2
"""
import json
import math
import os

from fontTools.svgLib.path import parse_path
from fontTools.pens.recordingPen import RecordingPen
from fontTools.pens.transformPen import TransformPen
from fontTools.pens.boundsPen import BoundsPen
from fontTools.pens.cu2quPen import Cu2QuPen
from fontTools.pens.ttGlyphPen import TTGlyphPen
from fontTools.misc.transform import Transform
from fontTools.fontBuilder import FontBuilder
from fontTools.ttLib import newTable

HERE = os.path.dirname(os.path.abspath(__file__))
MANIFEST = os.path.join(HERE, "..", "source", "glyphs.json")
OUT_DIR = os.path.join(HERE, "..", "build")

UPM = 1000
CAP = 700  # target cap height in font units, common across all weights

UPPER = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
LOWER = "abcdefghijklmnopqrstuvwxyz"
DIGITS = "1234567890"

# stroke-width heuristic (fraction of cap height) per weight, used to size
# the procedurally-drawn diacritics and punctuation to match each weight
STROKE_FRAC = {
    "Light": 0.050,
    "Regular": 0.072,
    "SemiBold": 0.098,
    "Bold": 0.128,
    "Black": 0.170,
}

WEIGHT_CLASS = {"Light": 300, "Regular": 400, "SemiBold": 600, "Bold": 700, "Black": 900}

# Fraction of cap-height used as left+right side bearing. The source specimen
# was set too tight to measure real inter-letter gaps (adjacent bounding
# boxes touch/overlap at small sizes), so this is a fixed typographic
# default instead of a measured value, tightening slightly for heavier
# weights the way most type families do.
BEARING_FRAC = {"Light": 0.065, "Regular": 0.058, "SemiBold": 0.050, "Bold": 0.045, "Black": 0.040}

GLYPH_NAME = {}
for ch in UPPER + LOWER:
    GLYPH_NAME[ch] = ch if ch.isupper() else ch + ".lc" if False else ch
for d in DIGITS:
    pass

UNI_NAME = {
    "asterisk": 0x2A, "ampersand": 0x26, "asciicircum": 0x5E, "percent": 0x25,
    "dollar": 0x24, "numbersign": 0x23, "at": 0x40, "exclam": 0x21,
    "parenleft": 0x28, "parenright": 0x29, "plus": 0x2B, "hyphen": 0x2D,
}

ACCENT_MAP = {
    # lower -> (base, mark)
    "aacute": ("a", "acute"), "acircumflex": ("a", "circumflex"), "atilde": ("a", "tilde"), "agrave": ("a", "grave"),
    "eacute": ("e", "acute"), "ecircumflex": ("e", "circumflex"),
    "iacute": ("i", "acute"),
    "oacute": ("o", "acute"), "ocircumflex": ("o", "circumflex"), "otilde": ("o", "tilde"),
    "uacute": ("u", "acute"), "udieresis": ("u", "dieresis"),
    "ccedilla": ("c", "cedilla"),
}
ACCENT_UNI = {
    "aacute": 0x00E1, "acircumflex": 0x00E2, "atilde": 0x00E3, "agrave": 0x00E0,
    "eacute": 0x00E9, "ecircumflex": 0x00EA,
    "iacute": 0x00ED,
    "oacute": 0x00F3, "ocircumflex": 0x00F4, "otilde": 0x00F5,
    "uacute": 0x00FA, "udieresis": 0x00FC,
    "ccedilla": 0x00E7,
    "Aacute": 0x00C1, "Acircumflex": 0x00C2, "Atilde": 0x00C3, "Agrave": 0x00C0,
    "Eacute": 0x00C9, "Ecircumflex": 0x00CA,
    "Iacute": 0x00CD,
    "Oacute": 0x00D3, "Ocircumflex": 0x00D4, "Otilde": 0x00D5,
    "Uacute": 0x00DA, "Udieresis": 0x00DC,
    "Ccedilla": 0x00C7,
}


def bounds_of(rec):
    bp = BoundsPen(None)
    rec.replay(bp)
    return bp.bounds  # xmin,ymin,xmax,ymax or None


def translated(rec, dx, dy):
    out = RecordingPen()
    tp = TransformPen(out, Transform(1, 0, 0, 1, dx, dy))
    rec.replay(tp)
    return out


def scaled(rec, sx, sy, cx=0, cy=0):
    out = RecordingPen()
    t = Transform(1, 0, 0, 1, cx, cy).scale(sx, sy).translate(-cx, -cy)
    tp = TransformPen(out, t)
    rec.replay(tp)
    return out


def combine(*recs):
    out = RecordingPen()
    for r in recs:
        r.replay(out)
    return out


def rect_pen(x0, y0, x1, y1):
    pen = RecordingPen()
    pen.moveTo((x0, y0))
    pen.lineTo((x1, y0))
    pen.lineTo((x1, y1))
    pen.lineTo((x0, y1))
    pen.closePath()
    return pen


def poly_pen(pts):
    pen = RecordingPen()
    pen.moveTo(pts[0])
    for p in pts[1:]:
        pen.lineTo(p)
    pen.closePath()
    return pen


def ball(cx, cy, r):
    """Simple round dot/terminal built from four cubic curves."""
    k = r * 0.5523
    pen = RecordingPen()
    pen.moveTo((cx - r, cy))
    pen.curveTo((cx - r, cy + k), (cx - k, cy + r), (cx, cy + r))
    pen.curveTo((cx + k, cy + r), (cx + r, cy + k), (cx + r, cy))
    pen.curveTo((cx + r, cy - k), (cx + k, cy - r), (cx, cy - r))
    pen.curveTo((cx - k, cy - r), (cx - r, cy - k), (cx - r, cy))
    pen.closePath()
    return pen


def tapered_stroke(x0, y0, x1, y1, w0, w1):
    """A straight stroke from (x0,y0) width w0 to (x1,y1) width w1,
    perpendicular caps -- gives the thick-to-thin 'flag' look of a
    Didone acute/grave accent."""
    dx, dy = x1 - x0, y1 - y0
    length = math.hypot(dx, dy) or 1
    nx, ny = -dy / length, dx / length
    pts = [
        (x0 + nx * w0 / 2, y0 + ny * w0 / 2),
        (x1 + nx * w1 / 2, y1 + ny * w1 / 2),
        (x1 - nx * w1 / 2, y1 - ny * w1 / 2),
        (x0 - nx * w0 / 2, y0 - ny * w0 / 2),
    ]
    return poly_pen(pts)


def sample_cubic(p0, p1, p2, p3, n=16):
    pts = []
    for i in range(n + 1):
        t = i / n
        mt = 1 - t
        x = mt ** 3 * p0[0] + 3 * mt ** 2 * t * p1[0] + 3 * mt * t ** 2 * p2[0] + t ** 3 * p3[0]
        y = mt ** 3 * p0[1] + 3 * mt ** 2 * t * p1[1] + 3 * mt * t ** 2 * p2[1] + t ** 3 * p3[1]
        pts.append((x, y))
    return pts


def stroke_polyline(points, half_widths):
    """Variable-width stroke along a polyline centerline -> closed polygon
    (butt caps). points/half_widths are parallel lists."""
    n = len(points)
    left, right = [], []
    for i in range(n):
        if i == 0:
            dx, dy = points[1][0] - points[0][0], points[1][1] - points[0][1]
        elif i == n - 1:
            dx, dy = points[-1][0] - points[-2][0], points[-1][1] - points[-2][1]
        else:
            dx, dy = points[i + 1][0] - points[i - 1][0], points[i + 1][1] - points[i - 1][1]
        length = math.hypot(dx, dy) or 1
        nx, ny = -dy / length, dx / length
        hw = half_widths[i]
        left.append((points[i][0] + nx * hw, points[i][1] + ny * hw))
        right.append((points[i][0] - nx * hw, points[i][1] - ny * hw))
    return poly_pen(left + list(reversed(right)))


def make_acute(sw, height):
    # thick bottom-left tapering to a thin point top-right
    return tapered_stroke(-height * 0.28, 0, height * 0.30, height, sw * 1.6, sw * 0.3)


def make_grave(sw, height):
    return tapered_stroke(height * 0.28, 0, -height * 0.30, height, sw * 1.6, sw * 0.3)


def make_circumflex(sw, height):
    # both legs taper to zero width exactly at the shared apex so they meet
    # at a point instead of overlapping into a blob
    left = tapered_stroke(0, height, -height * 0.34, 0, 0, sw * 1.05)
    right = tapered_stroke(0, height, height * 0.34, 0, 0, sw * 1.05)
    return combine(left, right)


def make_tilde(sw, height):
    w = height * 2.0
    amp = height * 0.42
    n = 40
    pts = []
    for i in range(n + 1):
        t = i / n
        x = -w / 2 + w * t
        y = amp * math.sin(2 * math.pi * t)
        pts.append((x, y))
    hws = []
    for i in range(n + 1):
        t = i / n
        edge = min(t, 1 - t) * 2  # 0 at ends -> 1 at middle
        hws.append((sw * 0.35 + sw * 0.55 * edge) / 2)
    return stroke_polyline(pts, hws)


def make_dieresis(sw, height):
    r = sw * 0.5
    gap = r * 3.4
    d1 = ball(-gap / 2, height * 0.55, r)
    d2 = ball(gap / 2, height * 0.55, r)
    return combine(d1, d2)


def make_cedilla(sw, cap_height):
    # small hooked tail hanging below the baseline, tapering thick-to-thin
    h = cap_height * 0.30
    w = cap_height * 0.20
    p0 = (0.0, 0.0)
    c1 = (w * 1.0, -h * 0.18)
    c2 = (w * 1.05, -h * 0.62)
    p3 = (w * 0.30, -h * 0.80)
    c4 = (-w * 0.35, -h * 0.95)
    c5 = (-w * 0.42, -h * 0.55)
    p6 = (w * 0.05, -h * 0.42)
    pts = sample_cubic(p0, c1, c2, p3, 14)[:-1] + sample_cubic(p3, c4, c5, p6, 14)
    n = len(pts)
    hws = [max(sw * 0.14, sw * 0.55 * (1 - i / (n - 1))) for i in range(n)]
    return stroke_polyline(pts, hws)


def make_plus(sw, x_height):
    w = x_height * 0.72
    t = sw * 0.85
    cy = x_height * 0.42
    h_bar = rect_pen(-w / 2, cy - t / 2, w / 2, cy + t / 2)
    v_bar = rect_pen(-t / 2, cy - w / 2, t / 2, cy + w / 2)
    return combine(h_bar, v_bar)


def make_hyphen(sw, x_height):
    w = x_height * 0.62
    t = sw * 0.80
    cy = x_height * 0.42
    return rect_pen(-w / 2, cy - t / 2, w / 2, cy + t / 2)


def make_period(sw):
    return ball(0, sw * 0.55, sw * 0.62)


def make_comma(sw):
    body = ball(0, sw * 0.5, sw * 0.6)
    tail = tapered_stroke(0, sw * 0.1, -sw * 0.55, -sw * 1.55, sw * 0.9, sw * 0.15)
    return combine(body, tail)


def make_colon(sw, x_height):
    top = ball(0, x_height * 0.72, sw * 0.6)
    bot = ball(0, sw * 0.55, sw * 0.6)
    return combine(top, bot)


def make_semicolon(sw, x_height):
    top = ball(0, x_height * 0.72, sw * 0.6)
    body = ball(0, sw * 0.5, sw * 0.6)
    tail = tapered_stroke(0, sw * 0.1, -sw * 0.55, -sw * 1.55, sw * 0.9, sw * 0.15)
    return combine(top, body, tail)


def make_quotesingle(sw, cap_height):
    return tapered_stroke(0, cap_height * 0.55, sw * 0.4, cap_height, sw * 0.95, sw * 0.35)


def make_quotedbl(sw, cap_height):
    left = translated(make_quotesingle(sw, cap_height), -sw * 0.9, 0)
    right = translated(make_quotesingle(sw, cap_height), sw * 0.9, 0)
    return combine(left, right)


def make_question(sw, cap_height):
    # an open circular loop (like a "6" coil, open at the bottom) that
    # tapers into a tail curling down to a stem tip above a separate dot
    h = cap_height
    R = h * 0.225
    cx, cy = 0.0, h * 0.775
    start_deg, end_deg = 197, -33  # sweeps clockwise, leaving a gap at the bottom
    n = 34
    arc_pts, arc_hw = [], []
    for i in range(n + 1):
        t = i / n
        deg = start_deg + (end_deg - start_deg) * t
        rad = math.radians(deg)
        arc_pts.append((cx + R * math.cos(rad), cy + R * math.sin(rad)))
        taper_in = min(t / 0.15, 1.0)       # thin->thick near the start terminal
        taper_out = min((1 - t) / 0.45, 1.0)  # thick->thin heading into the tail
        arc_hw.append(sw * (0.20 + 0.46 * taper_in * taper_out))

    tail_end = (cx + R * math.cos(math.radians(end_deg)), cy + R * math.sin(math.radians(end_deg)))
    tip = (h * 0.04, h * 0.42)
    c1 = (tail_end[0] + h * 0.02, tail_end[1] - h * 0.14)
    c2 = (tip[0] + h * 0.02, tip[1] + h * 0.06)
    tail_pts = sample_cubic(tail_end, c1, c2, tip, 14)[1:]
    tail_hw = [sw * (0.22 + 0.16 * (1 - i / (len(tail_pts) - 1))) for i in range(len(tail_pts))]

    pts = arc_pts + tail_pts
    hws = arc_hw + tail_hw
    hook = stroke_polyline(pts, hws)
    dot = ball(h * 0.04, sw * 0.55, sw * 0.62)
    return combine(hook, dot)


class GlyphBuilder:
    def __init__(self, wname, wdata):
        self.wname = wname
        self.metrics = wdata["metrics"]
        self.scale = CAP / self.metrics["cap_height"]
        self.cap = CAP
        self.xh = self.metrics["x_height"] * self.scale
        self.desc = self.metrics["descender"] * self.scale
        self.sw = STROKE_FRAC[wname] * CAP
        self.recordings = {}   # name -> RecordingPen, self-contained (own LSB origin)
        self.advances = {}
        self._compute_bearing(wdata)
        self._import_letters(wdata)

    def _compute_bearing(self, wdata):
        self.bearing = BEARING_FRAC[self.wname] * CAP

    def _transform_for(self, cls):
        m = self.metrics
        baseline = {"upper": m["baseline_upper"], "lower": m["baseline_lower"], "digit": m["baseline_digits"]}[cls]
        return baseline

    def _import_one(self, ch, gdata, cls):
        baseline = self._transform_for(cls)
        xmin = gdata["xmin"]
        t = Transform(self.scale, 0, 0, -self.scale, -xmin * self.scale + self.bearing, baseline * self.scale)
        rec = RecordingPen()
        tp = TransformPen(rec, t)
        parse_path(gdata["d"], tp)
        width = (gdata["xmax"] - gdata["xmin"]) * self.scale + 2 * self.bearing
        self.recordings[ch] = rec
        self.advances[ch] = width

    def _import_letters(self, wdata):
        gl = wdata["glyphs"]
        for ch in UPPER:
            self._import_one(ch, gl[ch], "upper")
        for ch in LOWER:
            self._import_one(ch, gl[ch], "lower")
        for ch in DIGITS:
            self._import_one(ch, gl[ch], "digit")

    def add_recording(self, name, rec, width):
        self.recordings[name] = rec
        self.advances[name] = width

    def bbox(self, name):
        return bounds_of(self.recordings[name])

    def make_diacritics(self):
        sw = self.sw
        self.marks = {
            "acute": make_acute(sw, self.cap * 0.30),
            "grave": make_grave(sw, self.cap * 0.30),
            "circumflex": make_circumflex(sw, self.cap * 0.26),
            "tilde": make_tilde(sw, self.cap * 0.22),
            "dieresis": make_dieresis(sw, self.cap * 0.20),
        }

    def compose_accent(self, base_ch, mark_name, is_upper):
        base = self.recordings[base_ch]
        bbox = self.bbox(base_ch)
        if base_ch == "i" and mark_name in ("acute", "grave", "circumflex", "tilde", "dieresis"):
            base, bbox = self._dotless_i()
        bx0, by0, bx1, by1 = bbox
        cx = (bx0 + bx1) / 2

        if mark_name == "cedilla":
            mark = make_cedilla(self.sw, self.cap)
            mx0, my0, mx1, my1 = bounds_of(mark)
            dx = cx - (mx0 + mx1) / 2
            dy = 0  # cedilla already authored to hang at baseline (y=0)
            mark_t = translated(mark, dx, dy)
            width = self.advances[base_ch]
            return combine(base, mark_t), width

        mark = self.marks[mark_name]
        mx0, my0, mx1, my1 = bounds_of(mark)
        top_ref = self.cap if is_upper else self.xh
        gap = self.cap * 0.06
        dx = cx - (mx0 + mx1) / 2
        dy = top_ref + gap - my0
        mark_t = translated(mark, dx, dy)
        width = self.advances[base_ch]
        return combine(base, mark_t), width

    def _dotless_i(self):
        """Split the authored 'i' into contours and drop the dot (topmost,
        smallest contour) so accents sit directly on the stem."""
        rec = self.recordings["i"]
        contours = []
        cur = []
        for op, args in rec.value:
            if op == "moveTo" and cur:
                contours.append(cur)
                cur = []
            cur.append((op, args))
        if cur:
            contours.append(cur)
        if len(contours) < 2:
            return rec, self.bbox("i")

        def cbounds(c):
            tmp = RecordingPen()
            tmp.value = c
            return bounds_of(tmp)

        boxes = [cbounds(c) for c in contours]
        # dot = contour with the smallest area whose bbox sits above the others
        areas = [(b[2] - b[0]) * (b[3] - b[1]) for b in boxes]
        dot_idx = min(range(len(contours)), key=lambda i: areas[i])
        stem_contours = [c for i, c in enumerate(contours) if i != dot_idx]
        out = RecordingPen()
        for c in stem_contours:
            out.value.extend(c)
        stem_boxes = [b for i, b in enumerate(boxes) if i != dot_idx]
        x0 = min(b[0] for b in stem_boxes)
        y0 = min(b[1] for b in stem_boxes)
        x1 = max(b[2] for b in stem_boxes)
        y1 = max(b[3] for b in stem_boxes)
        return out, (x0, y0, x1, y1)

    def make_punct(self):
        sw = self.sw
        self.add_recording("period", make_period(sw), sw * 2.6)
        self.add_recording("comma", make_comma(sw), sw * 2.6)
        self.add_recording("colon", make_colon(sw, self.xh), sw * 2.6)
        self.add_recording("semicolon", make_semicolon(sw, self.xh), sw * 2.8)
        self.add_recording("quotesingle", make_quotesingle(sw, self.cap), sw * 2.4)
        self.add_recording("quotedbl", make_quotedbl(sw, self.cap), sw * 4.2)
        self.add_recording("question", make_question(sw, self.cap), self.cap * 0.62)
        self.add_recording("space", RecordingPen(), self.cap * 0.55)
        self.add_recording("plus", make_plus(sw, self.xh), self.xh * 0.85)
        self.add_recording("hyphen", make_hyphen(sw, self.xh), self.xh * 0.55)


def import_specialchars(gb, special, ref_cap_scale):
    """Import the single authored special-character set (drawn once, in the
    Petala/specimen row) and scale it to this weight's cap height. 'plus' and
    'hyphen' are skipped here -- the source drew them as near-invisible
    hairlines, so build_weight uses the procedural versions from make_punct
    instead."""
    for name, gdata in special.items():
        if name in ("asterisk2", "plus", "hyphen"):
            continue
        baseline = ref_cap_scale["baseline"]
        scale = CAP / ref_cap_scale["cap"]
        xmin = gdata["xmin"]
        t = Transform(scale, 0, 0, -scale, -xmin * scale + gb.bearing, baseline * scale)
        rec = RecordingPen()
        tp = TransformPen(rec, t)
        parse_path(gdata["d"], tp)
        width = (gdata["xmax"] - gdata["xmin"]) * scale + 2 * gb.bearing
        gb.add_recording(name, rec, width)


def finalize_to_ttglyph(rec):
    ttpen = TTGlyphPen(None)
    cu2qu = Cu2QuPen(ttpen, max_err=1.0, reverse_direction=True)
    rec.replay(cu2qu)
    return ttpen.glyph()


def build_weight(wname, wdata, special, petala):
    gb = GlyphBuilder(wname, wdata)
    gb.make_diacritics()
    gb.make_punct()

    ref_cap = {"cap": petala["P"]["ymax"] - petala["P"]["ymin"], "baseline": petala["P"]["ymax"]}
    import_specialchars(gb, special, ref_cap)

    glyph_order = [".notdef"]
    cmap = {}
    advance_widths = {}
    ttglyphs = {}
    recs = {}

    def add(name, rec, width, uni=None):
        glyph_order.append(name)
        advance_widths[name] = int(round(width))
        ttglyphs[name] = finalize_to_ttglyph(rec)
        recs[name] = rec
        if uni is not None:
            cmap[uni] = name

    notdef_rec = rect_pen(50, 0, CAP * 0.6, CAP)
    ttglyphs[".notdef"] = finalize_to_ttglyph(notdef_rec)
    advance_widths[".notdef"] = int(round(CAP * 0.7))
    recs[".notdef"] = notdef_rec

    for ch in UPPER + LOWER:
        add(ch, gb.recordings[ch], gb.advances[ch], ord(ch))
    for ch in DIGITS:
        add(ch, gb.recordings[ch], gb.advances[ch], ord(ch))
    for name, uni in UNI_NAME.items():
        if name in gb.recordings:
            add(name, gb.recordings[name], gb.advances[name], uni)
    for name in ("period", "comma", "colon", "semicolon", "quotesingle", "quotedbl", "question", "space"):
        uni = {"period": 0x2E, "comma": 0x2C, "colon": 0x3A, "semicolon": 0x3B,
               "quotesingle": 0x27, "quotedbl": 0x22, "question": 0x3F, "space": 0x20}[name]
        add(name, gb.recordings[name], gb.advances[name], uni)

    for gname, (base_ch, mark_name) in ACCENT_MAP.items():
        is_upper = base_ch.isupper()
        rec, width = gb.compose_accent(base_ch, mark_name, is_upper=False)
        add(gname, rec, width, ACCENT_UNI[gname])
        upper_base = base_ch.upper()
        upper_gname = gname[0].upper() + gname[1:]
        rec_u, width_u = gb.compose_accent(upper_base, mark_name, is_upper=True)
        add(upper_gname, rec_u, width_u, ACCENT_UNI[upper_gname])

    return glyph_order, cmap, advance_widths, ttglyphs, gb, recs


def _common_metrics(gb):
    ascent = int(CAP + gb.xh * 0.5 + 220)
    descent = int(-(abs(gb.desc) + 200))
    return ascent, descent


def _name_strings(family, style):
    return dict(
        familyName=f"{family} {style}" if style not in ("Regular",) else family,
        styleName="Regular",
        uniqueFontIdentifier=f"{family}-{style}:2026",
        fullName=f"{family} {style}",
        psName=f"{family.replace(' ', '')}-{style}",
        version="Version 1.000",
    )


def save_font_ttf(family, wname, glyph_order, cmap, advance_widths, ttglyphs, gb, path):
    fb = FontBuilder(UPM, isTTF=True)
    fb.setupGlyphOrder(glyph_order)
    fb.setupCharacterMap(cmap)
    fb.setupGlyf(ttglyphs)
    metrics = {name: (advance_widths[name], ttglyphs[name].xMin if hasattr(ttglyphs[name], "xMin") and ttglyphs[name].numberOfContours else 0)
               for name in glyph_order}
    fb.setupHorizontalMetrics(metrics)
    ascent, descent = _common_metrics(gb)
    fb.setupHorizontalHeader(ascent=ascent, descent=descent)
    fb.setupNameTable(_name_strings(family, wname))
    fb.setupOS2(sTypoAscender=ascent, sTypoDescender=descent, sTypoLineGap=0,
                usWinAscent=ascent, usWinDescent=abs(descent),
                sxHeight=int(gb.xh), sCapHeight=CAP,
                usWeightClass=WEIGHT_CLASS[wname])
    fb.setupPost()
    fb.setupDummyDSIG()
    fb.save(path)
    print("saved", path)
    return fb.font


def save_font_otf(family, wname, glyph_order, cmap, advance_widths, recs, gb, path):
    from fontTools.pens.t2CharStringPen import T2CharStringPen

    charstrings = {}
    for name in glyph_order:
        pen = T2CharStringPen(advance_widths[name], None)
        recs[name].replay(pen)
        charstrings[name] = pen.getCharString()

    psname = f"{family.replace(' ', '')}-{wname}"
    fb = FontBuilder(UPM, isTTF=False)
    fb.setupGlyphOrder(glyph_order)
    fb.setupCharacterMap(cmap)
    fb.setupCFF(psname, {}, charstrings, {})
    metrics = {name: (advance_widths[name], 0) for name in glyph_order}
    fb.setupHorizontalMetrics(metrics)
    ascent, descent = _common_metrics(gb)
    fb.setupHorizontalHeader(ascent=ascent, descent=descent)
    fb.setupNameTable(_name_strings(family, wname))
    fb.setupOS2(sTypoAscender=ascent, sTypoDescender=descent, sTypoLineGap=0,
                usWinAscent=ascent, usWinDescent=abs(descent),
                sxHeight=int(gb.xh), sCapHeight=CAP,
                usWeightClass=WEIGHT_CLASS[wname])
    fb.setupPost()
    fb.save(path)
    print("saved", path)


def save_web_fonts(ttf_path, woff_path, woff2_path):
    from fontTools.ttLib import TTFont
    for flavor, out_path in (("woff", woff_path), ("woff2", woff2_path)):
        f = TTFont(ttf_path)
        f.flavor = flavor
        f.save(out_path)
        print("saved", out_path)


def main():
    manifest = json.load(open(MANIFEST))
    family = "Bem Me Quer"
    os.makedirs(OUT_DIR, exist_ok=True)
    for wname, wdata in manifest["weights"].items():
        glyph_order, cmap, advance_widths, ttglyphs, gb, recs = build_weight(
            wname, wdata, manifest["specialchars"], manifest["petala"])
        base = f"{family.replace(' ', '')}-{wname}"
        ttf_path = os.path.join(OUT_DIR, base + ".ttf")
        otf_path = os.path.join(OUT_DIR, base + ".otf")
        woff_path = os.path.join(OUT_DIR, base + ".woff")
        woff2_path = os.path.join(OUT_DIR, base + ".woff2")

        save_font_ttf(family, wname, glyph_order, cmap, advance_widths, ttglyphs, gb, ttf_path)
        save_font_otf(family, wname, glyph_order, cmap, advance_widths, recs, gb, otf_path)
        save_web_fonts(ttf_path, woff_path, woff2_path)


if __name__ == "__main__":
    main()
