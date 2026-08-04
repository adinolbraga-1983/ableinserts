# Figma as the Connective Layer

Figma is the piece that ties the whole skill together: design tokens and components live
there, and finished code should be able to flow back into it so designers keep one source
of truth instead of code and design drifting apart. Treat it as bidirectional, not a
one-time export.

## Reading from Figma (design → code)

Before building anything new, check whether it already exists in the file:
- `get_design_context` — pull the structured design data (layout, spacing, type, color) for
  a frame/selection. Start here for "implement this Figma frame" style work.
- `get_variable_defs` — pull design tokens (color, spacing, type variables) so code uses the
  same named values as the design file instead of eyeballed hex codes and pixel values.
- `get_libraries` / `search_design_system` — check for existing components before building
  a new one from scratch; reusing a documented component beats inventing a visually-similar
  one-off.
- `get_screenshot` — grab a visual reference when structured data alone doesn't convey the
  intent (e.g., a custom illustration or effect).
- `get_metadata` — lightweight structural overview when you need the shape of a file without
  pulling full design context for every node.

## Writing to Figma (code → design)

- `use_figma` is the general-purpose tool for generating/editing Figma content from intent
  or code. **Load the `/figma-use` skill (or the `skill://figma/figma-use/SKILL.md`
  fallback) before calling it** — it's a hard requirement, not optional context, because
  `use_figma` behaves correctly only when driven through that skill's guidance.
  `get_figma_skill` covers other Figma-specific skills for design-system generation
  (`/figma-generate-library`), page-to-Figma translation (`/figma-generate-design`), and
  Code Connect mapping (`/figma-code-connect`) — check whether one of those fits better than
  a raw `use_figma` call.
- `create_new_file` for starting a fresh Figma file from a build (e.g., pushing a finished
  landing page back as an editable Figma document for the design team).
- `add_code_connect_map` / `get_code_connect_map` to keep Figma components mapped to their
  real codebase implementations, so "this Figma component" and "this React component" stay
  linked instead of silently diverging over time.

## Practical sequencing

1. `get_design_context` (+ `get_variable_defs`) on the relevant frame before writing any
   component code.
2. Build using the sourced tokens, following the rest of this skill for the actual visual/
   motion decisions Figma doesn't dictate (micro-interaction timing, 3D elements, critique
   pass).
3. If the result should be editable by non-engineers or reviewed by designers, push it back
   via the `/figma-use` flow or `create_new_file` rather than letting it live only as code.
4. If a component is meant to be reused, register it with Code Connect so future Figma-to-
   code handoffs for that component are automatic instead of re-derived from scratch.

If no Figma file exists yet for this project, don't block on it — build from the brief and
the other references, but flag to the user that establishing a Figma design-token source of
truth would tighten this loop for future work.
