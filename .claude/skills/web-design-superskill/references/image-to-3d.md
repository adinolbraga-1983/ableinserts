# Image → 3D: the img2threejs Approach

`img2threejs` rebuilds an object from a reference image as a **code-only, procedural,
animation-ready Three.js model** rather than photogrammetry or a baked mesh export. That
distinction matters for how to use the approach in this project.

## What "code-only, procedural" means in practice

Instead of scanning/reconstructing a mesh from photos (photogrammetry) or hand-modeling in
a DCC tool and exporting a `.glb`, the pipeline treats the reference image as a spec: read
the object's proportions, materials, and silhouette from the image, then construct it with
Three.js primitives, extrusions, and procedural geometry, driven entirely by code. The
payoff is a model that's:
- **Lightweight** — no multi-megabyte mesh/texture assets to ship, just geometry-generating
  code and small material maps.
- **Animation-ready by construction** — because the object is built from named, code-level
  parts (not a single opaque imported mesh), individual parts can be targeted for GSAP-
  driven or Three.js-native animation without needing a rigged skeleton.
- **Quality-gated** — the object should be checked against the reference image for
  silhouette and proportion accuracy before being considered done, the same way any other
  design deliverable gets a critique pass (see `awwwards-critique.md`).

## When to reach for this vs. a plain 2D image

Use this pipeline when a brief specifically wants an object to feel present and inspectable
in 3D space — rotatable product heroes, an interactive object as a page's signature moment,
something that should react to scroll or cursor with real depth — not as a default upgrade
for every image on a page. A flat photo that just needs to sit in a layout doesn't need a
3D reconstruction; forcing everything into WebGL adds real performance and complexity cost
for no gain (see the performance non-negotiables in the main SKILL.md).

## Build checklist

1. Analyze the reference image for the object's major forms (what can be built from boxes,
   cylinders, extruded profiles, lathe geometry) rather than reaching for a generic
   catalog shape.
2. Break the object into named, independently-transformable parts/groups in the Three.js
   scene graph — this is what makes it animation-ready rather than a static import.
3. Approximate materials/color from the image (roughness, metalness, base color) rather
   than defaulting to a flat gray placeholder material.
4. Light the scene intentionally — an accurate model under flat/default lighting still
   reads as generic; a couple of purposeful lights (key + rim) does more for perceived
   quality than extra geometric detail.
5. Gate quality by comparing render angles against the source image's silhouette before
   treating the object as finished.
6. Wire in motion last: idle rotation, scroll-linked reveal, or pointer-reactive tilt via
   GSAP or Three.js's own animation loop, matching the timing/easing conventions in
   `motion-and-animation.md` rather than inventing a separate motion language for 3D
   content.
