/* ============================================================================
   Hero WebGL — "lente roxa"
   Plano Three.js com o vídeo como textura + shader duotone (ameixa).
   O scroll age como câmera: dolly-in, parallax de profundidade, o vídeo
   desacelera e o duotone aprofunda. Isolado de qualquer lógica de UI.
   ---------------------------------------------------------------------------
   Exporta initHeroWebGL({ canvas, video, onReady }) → { destroy } | null
   Retorna null quando WebGL não é suportado (o chamador mantém o fallback CSS).
   ========================================================================== */
/* THREE via global (UMD) */

const VERT = /* glsl */ `
  varying vec2 vUv;
  void main() {
    vUv = uv;
    gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
  }
`;

const FRAG = /* glsl */ `
  precision highp float;
  varying vec2 vUv;
  uniform sampler2D uTexture;
  uniform vec2  uCover;      // correção object-fit: cover
  uniform vec3  uShadow;     // ameixa profunda
  uniform vec3  uLight;      // mauve claro
  uniform float uProgress;   // 0 (topo) → 1 (fim do hero)
  uniform float uZoom;       // leve zoom por scroll

  void main() {
    // enquadramento "cover" + zoom sutil de câmera
    vec2 uv = (vUv - 0.5) / (uCover * uZoom) + 0.5;
    vec3 tex = texture2D(uTexture, uv).rgb;

    // luminância → duotone (a lente roxa)
    float l = dot(tex, vec3(0.299, 0.587, 0.114));
    l = clamp((l - 0.5) * 1.12 + 0.5, 0.0, 1.0);      // leve contraste
    vec3 duo = mix(uShadow, uLight, smoothstep(0.0, 1.0, l));

    // vinheta cinematográfica
    float d = distance(vUv, vec2(0.5, 0.42));
    float vig = smoothstep(0.95, 0.35, d);
    duo *= mix(0.72, 1.0, vig);

    // ao rolar, escurece para o conteúdo assumir
    duo = mix(duo, uShadow * 0.55, uProgress * 0.45);

    gl_FragColor = vec4(duo, 1.0);
  }
`;

function hex(v) {
  const c = new THREE.Color(v);
  return new THREE.Vector3(c.r, c.g, c.b);
}

function initHeroWebGL({ canvas, video, cssVar, onReady }) {
  // suporte a WebGL
  try {
    const test = document.createElement("canvas");
    if (!(test.getContext("webgl2") || test.getContext("webgl"))) return null;
  } catch (_) { return null; }

  const css = (name, fallback) =>
    getComputedStyle(document.documentElement).getPropertyValue(name).trim() || fallback;

  const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: false });
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
  camera.position.z = 2.4;

  const texture = new THREE.VideoTexture(video);
  texture.minFilter = THREE.LinearFilter;
  texture.magFilter = THREE.LinearFilter;
  texture.colorSpace = THREE.SRGBColorSpace;

  const uniforms = {
    uTexture: { value: texture },
    uCover:   { value: new THREE.Vector2(1, 1) },
    uShadow:  { value: hex(css("--duo-hero-shadow", "#2C1F2A")) },
    uLight:   { value: hex(css("--duo-hero-light", "#6A5B64")) },
    uProgress:{ value: 0 },
    uZoom:    { value: 1.06 },
  };

  const geometry = new THREE.PlaneGeometry(2, 2, 1, 1);
  const material = new THREE.ShaderMaterial({ vertexShader: VERT, fragmentShader: FRAG, uniforms });
  const mesh = new THREE.Mesh(geometry, material);
  scene.add(mesh);

  // dimensiona o plano para preencher a câmera + calcula "cover"
  function fitPlaneToCamera() {
    const dist = camera.position.z;
    const vFov = (camera.fov * Math.PI) / 180;
    const h = 2 * Math.tan(vFov / 2) * dist;
    const w = h * camera.aspect;
    mesh.scale.set(w / 2, h / 2, 1);
  }

  function updateCover() {
    const vw = video.videoWidth || 16, vh = video.videoHeight || 9;
    const cw = canvas.clientWidth || 1, ch = canvas.clientHeight || 1;
    const videoAspect = vw / vh, viewAspect = cw / ch;
    if (viewAspect > videoAspect) uniforms.uCover.value.set(1, videoAspect / viewAspect);
    else uniforms.uCover.value.set(viewAspect / videoAspect, 1);
  }

  function resize() {
    const w = canvas.clientWidth, h = canvas.clientHeight;
    renderer.setSize(w, h, false);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    fitPlaneToCamera();
    updateCover();
  }

  let raf = 0, ready = false;
  function loop() {
    if (video.readyState >= 2) {
      if (!ready) { ready = true; updateCover(); onReady && onReady(); }
      texture.needsUpdate = true;
    }
    renderer.render(scene, camera);
    raf = requestAnimationFrame(loop);
  }

  const ro = new ResizeObserver(resize);
  ro.observe(canvas);
  resize();
  video.play().catch(() => {}); // autoplay muted; se falhar, fallback cuida
  loop();

  return {
    /** progress 0→1 do scroll no hero: câmera + duotone + desaceleração */
    setProgress(p) {
      uniforms.uProgress.value = p;
      uniforms.uZoom.value = 1.06 + p * 0.14;          // dolly-in sutil
      camera.position.y = -p * 0.25;                    // deriva vertical
      camera.rotation.x = p * 0.05;                     // leve perspectiva
      camera.updateProjectionMatrix();
      // o vídeo desacelera conforme se rola (mantém vivo, nunca congela)
      try { video.playbackRate = Math.max(0.35, 1 - p * 0.7); } catch (_) {}
    },
    destroy() {
      cancelAnimationFrame(raf);
      ro.disconnect();
      geometry.dispose(); material.dispose(); texture.dispose(); renderer.dispose();
    },
  };
}

window.initHeroWebGL = initHeroWebGL;
