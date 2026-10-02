# Motion Studio — Flat Edition

A compact PHP + HTML + CSS + vanilla JavaScript motion-graphics editor for polished commercial teasers, kinetic type, product reveals, color fields, cards and clean morphing transitions.

## Flat folder

There are no runtime subfolders. These files all sit together:

- `index.php` — application shell
- `app.js` — editor, renderer, templates, timeline and video capture
- `app.css` — interface and template thumbnails
- `status.php` — FFmpeg availability check
- `transcode.php` — browser recording → H.264 MP4 converter
- `start.sh` / `start.bat` — launch helpers
- `START_HERE.txt` — quick setup
- `TESTED.md` — validation notes

## Run

```bash
php -S 127.0.0.1:8080
```

Then open `http://127.0.0.1:8080/`.

For reliable MP4 fallback, install FFmpeg and allow PHP to call `shell_exec`.

## 36 editable templates

### Product
Studio Light, Halo Device, Black Spotlight, Metal Precision, Midnight Hero, Soft Focus.

### Typography
Kinetic Stack, Split Type, Word Slice, Squeeze Title, Editorial, Giant Number.

### Color
Aurora Liquid, Prism Flow, Candy Wave, Neon Bloom, Sunset Glow, Spectrum Bars.

### UI & Glass
Glass Cards, Stacked UI, Feature Grid, Notification Stack, Metric Panel, Floating Chip.

### Classic
Pop Poster, Silhouette Pop, Color Blocks, Rainbow Stripes, Black + White, Retro Launch.

### Launch
Countdown, Clean Reveal, Orbit Rings, Ribbon, Spotlight CTA, End Card.

Every template is built from editable text, shapes and vector-style canvas elements. No Apple logos, product imagery, footage, or copied ad frames are included.

## Motion system

Element entrances include fade, slide, zoom, pop, squeeze X/Y, spin, blur, reveal, morph, stretch, whip and flip. Easing includes smooth, cubic, expo, back, spring and linear. Looping motion includes float, pulse, spin and breathe.

Scene transitions include fade, slide, push-up, zoom, wipe, squeeze, iris, flash and cut.

## Simple workflow

1. Pick a template.
2. Edit the selected headline in the right Inspector.
3. Drag objects on the canvas.
4. Switch to **Elements** to add text/shapes/icons.
5. Switch to **Scene** to edit duration, background and transition.
6. Add/extend scenes from the timeline.
7. Press Space to preview.
8. Export video.

## Export

The browser records the canvas using `canvas.captureStream()` and `MediaRecorder`.

- If the browser produces MP4 directly, it downloads MP4.
- If the browser produces WebM and FFmpeg is available, `transcode.php` converts it to H.264 MP4 (`yuv420p`, fast-start).
- If FFmpeg is unavailable, WebM is downloaded instead of failing silently.

For long/high-resolution projects you may need larger PHP `upload_max_filesize`, `post_max_size`, and `max_execution_time` values.

## Typography

The interface and new template text use **Inter**. The UI requests Inter from Google Fonts and falls back to the local system sans-serif stack if the remote font cannot load.

## Design note

The interface and motion language are original. They are informed by public principles around simplicity, hierarchy, continuity, restrained animation and fluid transitions used in high-end technology advertising. This project is not affiliated with or endorsed by Apple.
