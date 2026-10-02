<?php
declare(strict_types=1);
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com data:; img-src 'self' data: blob:; media-src 'self' blob:; connect-src 'self';");
?><!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
  <meta name="color-scheme" content="dark">
  <meta name="theme-color" content="#0b0b0c">
  <title>Motion Studio</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="app.css?v=4">
</head>
<body>
<div class="app" id="app">
  <header class="topbar">
    <div class="brand-cluster">
      <div class="brand" aria-label="Motion Studio">
        <div class="brand-mark" aria-hidden="true"><span></span></div>
        <div><strong>Motion Studio</strong><small>Fluid ads, simply.</small></div>
      </div>
      <div class="top-actions left-actions">
        <button class="icon-btn" id="newProjectBtn" title="New project" aria-label="New project">＋</button>
        <button class="icon-btn" id="undoBtn" title="Undo" aria-label="Undo">↶</button>
        <button class="icon-btn" id="redoBtn" title="Redo" aria-label="Redo">↷</button>
      </div>
    </div>

    <div class="transport" aria-label="Playback controls">
      <button class="transport-btn" id="restartBtn" title="Restart" aria-label="Restart">↺</button>
      <button class="play-btn" id="playBtn" title="Play or pause" aria-label="Play">▶</button>
      <span class="timecode" id="topTimecode">00:00.000</span>
    </div>

    <div class="top-actions right-actions">
      <button class="text-btn" id="saveBtn">Save</button>
      <button class="text-btn" id="projectMenuBtn">Project</button>
      <button class="primary-btn" id="exportBtn">Export</button>
    </div>
  </header>

  <main class="workspace">
    <aside class="sidebar">
      <div class="segmented" role="tablist" aria-label="Editor sections">
        <button class="segment active" data-panel="templates">Templates</button>
        <button class="segment" data-panel="add">Elements</button>
        <button class="segment" data-panel="scenes">Scene</button>
      </div>

      <div class="sidebar-panel active" id="panel-templates">
        <div class="template-hero">
          <div><strong>Start with motion</strong><span id="templateCount">36 templates</span></div>
          <p>Choose a complete look, then change the words, colors and timing.</p>
        </div>
        <label class="template-search-wrap">
          <span>⌕</span>
          <input id="templateSearch" type="search" placeholder="Search templates" autocomplete="off">
        </label>
        <div class="template-filters" id="templateFilters"></div>
        <div class="template-gallery" id="templateGallery"></div>
      </div>

      <div class="sidebar-panel" id="panel-add">
        <div class="panel-heading"><span>Elements</span><small>Click to add</small></div>
        <div class="add-grid">
          <button class="add-tile" data-add="heading"><span class="tile-icon">T</span><b>Heading</b><small>Bold text</small></button>
          <button class="add-tile" data-add="body"><span class="tile-icon small-t">t</span><b>Text</b><small>Supporting copy</small></button>
          <button class="add-tile" data-add="rect"><span class="tile-icon">▭</span><b>Card</b><small>Rounded shape</small></button>
          <button class="add-tile" data-add="circle"><span class="tile-icon">○</span><b>Circle</b><small>Glow or shape</small></button>
          <button class="add-tile" data-add="pill"><span class="tile-icon">▰</span><b>Pill</b><small>CTA or chip</small></button>
          <button class="add-tile" data-add="line"><span class="tile-icon">—</span><b>Line</b><small>Rule or accent</small></button>
          <button class="add-tile" data-add="sparkle"><span class="tile-icon">✦</span><b>Sparkle</b><small>Simple icon</small></button>
          <button class="add-tile" data-add="arrow"><span class="tile-icon">↗</span><b>Arrow</b><small>Direction</small></button>
          <button class="add-tile" data-add="playIcon"><span class="tile-icon">▷</span><b>Play</b><small>Media icon</small></button>
          <button class="add-tile" data-add="check"><span class="tile-icon">✓</span><b>Check</b><small>Feature icon</small></button>
        </div>
        <div class="tip-card"><strong>Fast editing</strong><p>Click an object on the canvas, drag it, then use the right panel for style and motion.</p></div>
      </div>

      <div class="sidebar-panel" id="panel-scenes">
        <div class="panel-heading"><span>Scenes</span><button class="mini-btn" id="addSceneSideBtn">＋ Add scene</button></div>
        <div id="sceneList" class="scene-list"></div>
        <div id="sceneSettings" class="scene-settings"></div>
      </div>
    </aside>

    <section class="stage-area">
      <div class="stage-toolbar">
        <div class="stage-meta"><strong id="sceneTitle">Scene 1</strong><span id="stageSizeLabel">1920 × 1080</span></div>
        <div class="stage-tools">
          <select id="resolutionSelect" class="compact-select" aria-label="Resolution">
            <option value="1920x1080">16:9 · 1080p</option>
            <option value="1280x720">16:9 · 720p</option>
            <option value="1080x1080">1:1 · Square</option>
            <option value="1080x1920">9:16 · Vertical</option>
          </select>
          <button class="mini-btn" id="snapshotBtn">Frame PNG</button>
        </div>
      </div>

      <div class="stage-viewport" id="stageViewport">
        <div class="canvas-shell" id="canvasShell">
          <canvas id="stage" width="1920" height="1080" aria-label="Motion canvas"></canvas>
          <div class="canvas-frame" aria-hidden="true"></div>
        </div>
        <div class="zoom-chip" id="zoomChip">Fit</div>
      </div>
    </section>

    <aside class="inspector">
      <div class="inspector-header">
        <div><strong id="inspectorTitle">Inspector</strong><small id="inspectorSubtitle">Select an element</small></div>
        <button class="icon-btn small" id="deleteElementTopBtn" title="Delete selected" aria-label="Delete selected">⌫</button>
      </div>
      <div id="inspectorBody" class="inspector-body"></div>
      <div class="layers-block">
        <div class="panel-heading layer-heading"><span>Layers</span><small>Front to back</small></div>
        <div id="layerList" class="layer-list"></div>
      </div>
    </aside>
  </main>

  <section class="timeline-area">
    <div class="timeline-header">
      <div class="timeline-title"><strong>Timeline</strong><span id="bottomTimecode">00:00.000</span></div>
      <div class="timeline-actions">
        <button class="mini-btn" id="addSceneBtn">＋ Scene</button>
        <button class="mini-btn" id="minusDurationBtn">− 1s</button>
        <button class="mini-btn" id="plusDurationBtn">＋ 1s</button>
        <label class="zoom-control">Zoom <input id="timelineZoom" type="range" min="60" max="180" value="96"></label>
      </div>
    </div>
    <div class="timeline-scroll" id="timelineScroll">
      <div class="timeline-content" id="timelineContent">
        <div class="ruler" id="ruler"></div>
        <div class="scene-track" id="sceneTrack"></div>
        <div class="element-track-wrap" id="elementTracks"></div>
        <div class="playhead" id="playhead" aria-hidden="true"></div>
      </div>
    </div>
  </section>
</div>

<div class="popover" id="projectPopover" hidden>
  <button id="downloadProjectBtn">Download project JSON</button>
  <button id="importProjectBtn">Import project JSON</button>
  <button id="loadSavedBtn">Load browser save</button>
  <hr>
  <button class="danger-text" id="clearSavedBtn">Clear browser save</button>
</div>
<input type="file" id="importProjectFile" accept="application/json,.json" hidden>

<div class="modal-backdrop" id="newProjectModal" hidden>
  <div class="modal wide-modal" role="dialog" aria-modal="true" aria-labelledby="newProjectTitle">
    <div class="modal-head"><div><h2 id="newProjectTitle">New project</h2><p>Pick a clean start. You can switch templates at any time.</p></div><button class="icon-btn" data-close-modal="newProjectModal">×</button></div>
    <div class="new-project-grid">
      <button class="choice-card" data-new-template="blank"><span class="blank-preview"></span><strong>Blank</strong><small>Start from one headline</small></button>
      <button class="choice-card" data-new-template="studioLight"><span class="choice-preview preview-orb"><i></i><b></b></span><strong>Studio Light</strong><small>Premium reveal</small></button>
      <button class="choice-card" data-new-template="kineticStack"><span class="choice-preview preview-type"><i></i><b></b></span><strong>Kinetic Stack</strong><small>Bold typography</small></button>
      <button class="choice-card" data-new-template="auroraLiquid"><span class="choice-preview preview-gradient"><i></i><b></b></span><strong>Aurora Liquid</strong><small>Fluid color</small></button>
    </div>
  </div>
</div>

<div class="modal-backdrop" id="exportModal" hidden>
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="exportTitle">
    <div class="modal-head"><div><h2 id="exportTitle">Export video</h2><p>The canvas is recorded in real time, then converted to MP4 when needed.</p></div><button class="icon-btn" data-close-modal="exportModal">×</button></div>
    <div class="export-grid">
      <div class="field"><label>Frame rate</label><select id="exportFps"><option>30</option><option>60</option><option>24</option></select></div>
      <div class="field"><label>Quality</label><select id="exportQuality"><option value="high">High</option><option value="standard">Standard</option></select></div>
    </div>
    <div class="export-status-card">
      <div class="status-row"><span>MP4 conversion</span><b id="ffmpegStatus">Checking…</b></div>
      <div class="status-row"><span>Duration</span><b id="exportDurationLabel">0s</b></div>
      <div class="progress"><span id="exportProgress"></span></div>
      <p id="exportStatusText">Ready.</p>
    </div>
    <div class="modal-actions"><button class="text-btn" data-close-modal="exportModal">Cancel</button><button class="primary-btn" id="startExportBtn">Export MP4</button></div>
  </div>
</div>

<div class="toast-stack" id="toastStack" aria-live="polite"></div>
<script src="app.js?v=4" defer></script>
</body>
</html>
