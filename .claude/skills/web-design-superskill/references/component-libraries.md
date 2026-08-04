# Component Libraries: Uiverse vs React Bits — Decision Tree

Both are free, open libraries. They solve different problems, so the first question is
always: **does this element need to move/respond, or does it just need to look right?**

## Use Uiverse.io technique when...

The element is a small, mostly-static UI atom: buttons, checkboxes, radio buttons, toggle
switches, inputs, cards, loaders, tooltips. Uiverse's whole value is that thousands of
authors have already sweated the fiddly CSS details (pseudo-element layering, border
gradients, active/focus states, `:not(:hover)` transition tricks) so these atoms feel
tactile instead of flat.

How to use it well:
- Study the CSS structure (custom properties, layered pseudo-elements, transition timing)
  rather than pasting the class names and colors verbatim.
- Re-derive the color values from the project's actual token set (from Figma if available)
  instead of keeping the original author's hex codes.
- Keep the interaction physics (the timing curves, the hover/active state logic) — that's
  the actually hard-won part — while changing the visual skin to match the project.
- Note that many Uiverse submissions are variations of other users' work (the browsed
  reference button was itself "a variation of barisdogansutcu's button") — treat any single
  snippet as one data point in a genre, not gospel.

## Use React Bits technique when...

The element needs to *do* something over time: animated text reveals, interactive
backgrounds that respond to cursor position, scroll-linked effects, custom cursors, particle
or grid backgrounds. React Bits components are built on GSAP and Framer Motion-style
primitives, so treat them as a curated gallery of "what's possible with these engines,"
not a black box to import unmodified.

How to use it well:
- Identify which underlying engine pattern powers the effect (GSAP timeline? scroll
  trigger? canvas/WebGL particle field?) — see `motion-and-animation.md` — and reimplement
  using that engine directly so the project has one animation dependency story, not a grab
  bag of copied component files.
- Prefer the free/MIT-style components; if a "Pro" variant is the only place an effect
  lives, treat that as a signal to build a simpler original version rather than a reason to
  gate the project behind a paid asset.
- Scale intensity to context: a full-viewport particle background belongs on a hero or
  landing page, not tucked into a settings panel.

## When neither fits

Ambitious, one-off "hero moment" pieces (a generative background, a custom WebGL scene, a
signature interaction) usually don't live in either library pre-built — that's exactly the
kind of thing the Awwwards critique pass and the img2threejs pipeline are for. Don't force
a library component into a role it wasn't built for just because it's convenient.
