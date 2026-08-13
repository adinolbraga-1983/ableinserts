#!/usr/bin/env python3
"""Stage A: parse vector.svg (from BemMeQuertype.ai) and extract per-glyph
path data + metrics into a JSON manifest for the font builder.
"""
import json
import os
from svgelements import SVG, Path

HERE = os.path.dirname(os.path.abspath(__file__))
SVG_PATH = os.path.join(HERE, "..", "source", "vector.svg")
OUT_PATH = os.path.join(HERE, "..", "source", "glyphs.json")

UPPER = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
LOWER = "abcdefghijklmnopqrstuvwxyz"
DIGITS = "1234567890"  # drawn order in the specimen


def load_items():
    svg = SVG.parse(SVG_PATH)
    items = []
    for i, el in enumerate(svg.elements()):
        if isinstance(el, Path) and len(el) > 0:
            bb = el.bbox()
            if bb is None:
                continue
            xmin, ymin, xmax, ymax = bb
            items.append({
                "idx": i, "d": el.d(),
                "xmin": xmin, "ymin": ymin, "xmax": xmax, "ymax": ymax,
                "cy": (ymin + ymax) / 2,
            })
    return items


def cluster_rows(items, tol=8):
    items = sorted(items, key=lambda p: p["cy"])
    rows, cur = [], []
    for it in items:
        if not cur:
            cur = [it]
            continue
        avg = sum(x["cy"] for x in cur) / len(cur)
        if abs(it["cy"] - avg) <= tol:
            cur.append(it)
        else:
            rows.append(cur)
            cur = [it]
    if cur:
        rows.append(cur)
    return rows


def split_by_gaps(row, n_groups, group_size):
    row = sorted(row, key=lambda p: p["xmin"])
    gaps = [(row[i]["xmin"] - row[i - 1]["xmax"], i) for i in range(1, len(row))]
    gaps.sort(reverse=True)
    cuts = sorted(i for _, i in gaps[: n_groups - 1])
    groups, start = [], 0
    for c in cuts:
        groups.append(row[start:c])
        start = c
    groups.append(row[start:])
    assert all(len(g) == group_size for g in groups), [len(g) for g in groups]
    return groups


def row_metrics(glyph_items_by_char):
    """Upper/lower/digits sit on three separate specimen lines, each with its
    own baseline in source SVG (y-down) coordinates -- compute each
    independently rather than assuming a shared baseline."""
    flat_upper = [c for c in "HEFLTI" if c in glyph_items_by_char]
    baseline_upper = sum(glyph_items_by_char[c]["ymax"] for c in flat_upper) / len(flat_upper)
    cap_top = sum(glyph_items_by_char[c]["ymin"] for c in flat_upper) / len(flat_upper)
    cap_height = baseline_upper - cap_top

    flat_lower = [c for c in "nuvwxz" if c in glyph_items_by_char]
    baseline_lower = sum(glyph_items_by_char[c]["ymax"] for c in flat_lower) / len(flat_lower)
    xh_top = sum(glyph_items_by_char[c]["ymin"] for c in flat_lower) / len(flat_lower)
    x_height = baseline_lower - xh_top

    desc_letters = [c for c in "gpqy" if c in glyph_items_by_char]
    descender = (max(glyph_items_by_char[c]["ymax"] for c in desc_letters) - baseline_lower) if desc_letters else cap_height * 0.22

    digit_chars = [c for c in DIGITS if c in glyph_items_by_char]
    baseline_digits = sum(glyph_items_by_char[c]["ymax"] for c in digit_chars) / len(digit_chars)

    return {
        "baseline_upper": baseline_upper, "cap_height": cap_height,
        "baseline_lower": baseline_lower, "x_height": x_height,
        "descender": descender, "baseline_digits": baseline_digits,
    }


def main():
    items = load_items()
    print("total path items:", len(items))
    rows = cluster_rows(items)
    for ri, row in enumerate(rows):
        row.sort(key=lambda p: p["xmin"])
        print(f"row {ri}: n={len(row)} y=({min(r['ymin'] for r in row):.1f}-{max(r['ymax'] for r in row):.1f})")

    weights_small_order = ["Light", "Regular", "SemiBold", "Bold"]

    manifest = {"weights": {}, "specialchars": {}, "petala": {}}

    # --- small weight table: row1=upper, row2=lower, row3=digits ---
    upper_groups = split_by_gaps(rows[1], 4, 26)
    lower_groups = split_by_gaps(rows[2], 4, 26)
    digit_groups = split_by_gaps(rows[3], 4, 10)

    for wi, wname in enumerate(weights_small_order):
        chars = {}
        for ch, it in zip(UPPER, upper_groups[wi]):
            chars[ch] = it
        for ch, it in zip(LOWER, lower_groups[wi]):
            chars[ch] = it
        for ch, it in zip(DIGITS, digit_groups[wi]):
            chars[ch] = it
        metrics = row_metrics(chars)
        manifest["weights"][wname] = {
            "metrics": metrics,
            "glyphs": {ch: {"d": it["d"], "xmin": it["xmin"], "xmax": it["xmax"],
                             "ymin": it["ymin"], "ymax": it["ymax"]}
                       for ch, it in chars.items()},
        }

    # --- Black weight big table: row10=upper, row11=lower, row12=digits ---
    chars = {}
    row10 = sorted(rows[10], key=lambda p: p["xmin"])
    row11 = sorted(rows[11], key=lambda p: p["xmin"])
    row12 = sorted(rows[12], key=lambda p: p["xmin"])
    assert len(row10) == 26 and len(row11) == 26 and len(row12) == 10
    for ch, it in zip(UPPER, row10):
        chars[ch] = it
    for ch, it in zip(LOWER, row11):
        chars[ch] = it
    for ch, it in zip(DIGITS, row12):
        chars[ch] = it
    metrics = row_metrics(chars)
    manifest["weights"]["Black"] = {
        "metrics": metrics,
        "glyphs": {ch: {"d": it["d"], "xmin": it["xmin"], "xmax": it["xmax"],
                         "ymin": it["ymin"], "ymax": it["ymax"]}
                   for ch, it in chars.items()},
    }

    # --- row4: Petala word (left) + special chars (right) ---
    row4 = sorted(rows[4], key=lambda p: p["xmin"])
    gaps = [(row4[i]["xmin"] - row4[i - 1]["xmax"], i) for i in range(1, len(row4))]
    gaps.sort(reverse=True)
    split_idx = gaps[0][1]
    petala_items = row4[:split_idx]
    special_items = row4[split_idx:]
    petala_word = "Pétala"
    assert len(petala_items) == len(petala_word), (len(petala_items), petala_word)
    for ch, it in zip(petala_word, petala_items):
        manifest["petala"][ch] = {"d": it["d"], "xmin": it["xmin"], "xmax": it["xmax"],
                                   "ymin": it["ymin"], "ymax": it["ymax"]}

    special_order = ["asterisk", "ampersand", "asciicircum", "percent", "dollar",
                      "numbersign", "at", "exclam", "asterisk2", "parenleft",
                      "parenright", "plus", "hyphen"]
    assert len(special_items) == len(special_order), (len(special_items), len(special_order))
    for name, it in zip(special_order, special_items):
        manifest["specialchars"][name] = {"d": it["d"], "xmin": it["xmin"], "xmax": it["xmax"],
                                           "ymin": it["ymin"], "ymax": it["ymax"]}

    with open(OUT_PATH, "w") as f:
        json.dump(manifest, f)
    print("wrote", OUT_PATH)
    for wname, wdata in manifest["weights"].items():
        print(wname, wdata["metrics"], "nglyphs=", len(wdata["glyphs"]))


if __name__ == "__main__":
    main()
