const cv  = document.getElementById('c');
const ctx = cv.getContext('2d');
let W, H, dpr;

function resize() {
  dpr = Math.min(window.devicePixelRatio||1,2);
  W   = window.innerWidth;
  H   = window.innerHeight;
  cv.width  = W * dpr;
  cv.height = H * dpr;
  cv.style.width  = W + 'px';
  cv.style.height = H + 'px';
  ctx.scale(dpr, dpr);
}
resize();
window.addEventListener('resize', resize);

let scrollP = 0, targetSP = 0;
const sc = document.getElementById('scene');

function rawP() {
  return Math.min(Math.max(window.scrollY/(sc.offsetHeight - H), 0), 1);
}
window.addEventListener('scroll',()=>{
  targetSP = rawP();
  document.getElementById('pbar').style.width = (targetSP*100)+'%';
  document.getElementById('nav').classList.toggle('scrolled', window.scrollY>80);
},{passive:true});

// ─── LERP (smooth like Apple) ────────────────────────────────────────────────────────────────────────
function lerp(a,b,t){return a+(b-a)*t;}

// ─── IMAGES (séquence vidéo simulée) ──────────────────────────────────────────────────────────
const TOTAL = 60;
const imgs  = [];
let   loaded = 0;
const BASE = (typeof adsData !== 'undefined' && adsData.themeUri)
  ? adsData.themeUri + '/assets/img/seq/'
  : '';

for(let i=1;i<=TOTAL;i++){
  const im = new Image();
  im.src = BASE + 'frame_' + String(i).padStart(4,'0') + '.jpg';
  im.onload = ()=>{ loaded++; };
  imgs.push(im);
}

// ─── COULEURS fond selon progression ───────────────────────────────────────────────────────
function bgColor(p){
  // 0 → blanc, 0.3→0.7 → encre, 1 → ambre doux
  if(p < 0.3){
    const t = p/0.3;
    return lerpColor([248,246,243],[26,23,20],t);
  } else if(p < 0.7){
    return [26,23,20];
  } else {
    const t = (p-0.7)/0.3;
    return lerpColor([26,23,20],[196,135,58],t);
  }
}
function lerpColor(a,b,t){
  return a.map((v,i)=>Math.round(v+(b[i]-v)*t));
}

// ─── PARTICULES ───────────────────────────────────────────────────────────────────────────
const N = 60;
const pts = Array.from({length:N},()=>({ x:Math.random()*1400, y:Math.random()*900,
  vx:(Math.random()-.5)*.4, vy:(Math.random()-.5)*.4,
  r:Math.random()*2+.5 }));

function drawParticles(alpha){
  pts.forEach(p=>{
    p.x += p.vx; p.y += p.vy;
    if(p.x<0||p.x>W) p.vx*=-1;
    if(p.y<0||p.y>H) p.vy*=-1;
    ctx.beginPath();
    ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
    ctx.fillStyle=`rgba(196,135,58,${alpha*0.6})`;
    ctx.fill();
  });
  // connect nearby
  for(let i=0;i<N;i++){
    for(let j=i+1;j<N;j++){
      const dx=pts[i].x-pts[j].x, dy=pts[i].y-pts[j].y;
      const d=Math.sqrt(dx*dx+dy*dy);
      if(d<120){
        ctx.beginPath();
        ctx.moveTo(pts[i].x,pts[i].y);
        ctx.lineTo(pts[j].x,pts[j].y);
        ctx.strokeStyle=`rgba(196,135,58,${alpha*(1-d/120)*0.3})`;
        ctx.lineWidth=.5;
        ctx.stroke();
      }
    }
  }
}

// ─── TEXTE OVERLAY ──────────────────────────────────────────────────────────────────────
const SCENES = [
  { p:[0,   .18], title:'L\'Art du Parfum',     sub:'UNE MAISON SENSORIELLE' },
  { p:[.20, .38], title:'Encens Ancestral',      sub:'R\u00c9SINES PR\u00c9CIEUSES' },
  { p:[.40, .58], title:'Eau de Parfum',         sub:'COLLECTION SIGNATURE' },
  { p:[.60, .78], title:'Bougies Rituelles',     sub:'CIRES NATURELLES' },
  { p:[.80,1.0 ], title:'La Collection 2026',   sub:'D\u00c9COUVRIR MAINTENANT' },
];

function drawText(p){
  const sc2 = SCENES.find(s=> p>=s.p[0] && p<=s.p[1]);
  if(!sc2) return;
  const local = (p-sc2.p[0])/(sc2.p[1]-sc2.p[0]);
  // fade in 0→0.25, hold, fade out 0.75→1
  let alpha;
  if(local<.25)       alpha = local/.25;
  else if(local<.75)  alpha = 1;
  else                alpha = 1-(local-.75)/.25;
  alpha = Math.max(0, Math.min(1, alpha));

  const isLight = p < 0.3;
  const textColor = isLight ? `rgba(26,23,20,${alpha})` : `rgba(255,255,255,${alpha})`;

  ctx.save();
  ctx.textAlign = 'center';
  // Sous-titre
  ctx.font = `300 ${clamp(10,14,W/100)}px Helvetica Neue, sans-serif`;
  ctx.letterSpacing = '0.2em';
  ctx.fillStyle = isLight
    ? `rgba(154,144,136,${alpha})`
    : `rgba(196,135,58,${alpha})`;
  ctx.fillText(sc2.sub, W/2, H/2 - clamp(30,55,H/15));
  // Titre
  ctx.font = `200 ${clamp(36,72,W/18)}px Helvetica Neue, sans-serif`;
  ctx.fillStyle = textColor;
  ctx.fillText(sc2.title, W/2, H/2 + clamp(10,20,H/50));
  ctx.restore();
}
function clamp(mn,mx,v){return Math.min(mx,Math.max(mn,v));}

// ─── RENDU PRINCIPAL ───────────────────────────────────────────────────────────────────────
function draw(){
  scrollP = lerp(scrollP, targetSP, .08);
  const p = scrollP;

  // Fond
  const [r,g,b] = bgColor(p);
  ctx.fillStyle = `rgb(${r},${g},${b})`;
  ctx.fillRect(0,0,W,H);

  // Image de séquence
  if(loaded > 0){
    const idx = Math.min(Math.floor(p*(TOTAL-1)), TOTAL-1);
    const img = imgs[idx];
    if(img && img.complete && img.naturalWidth > 0){
      const iw=img.naturalWidth, ih=img.naturalHeight;
      const scale=Math.max(W/iw, H/ih);
      const sw=iw*scale, sh=ih*scale;
      ctx.globalAlpha = 0.85;
      ctx.drawImage(img, (W-sw)/2, (H-sh)/2, sw, sh);
      ctx.globalAlpha = 1;
    }
  }

  // Particules (visibles surtout entre 0.15 et 0.85)
  const partAlpha = p < .15 ? p/.15 : p > .85 ? (1-p)/.15 : 1;
  drawParticles(partAlpha * .7);

  // Texte
  drawText(p);

  // Vignette
  const vig = ctx.createRadialGradient(W/2,H/2,H*.2,W/2,H/2,H*.85);
  vig.addColorStop(0,'rgba(0,0,0,0)');
  vig.addColorStop(1,`rgba(0,0,0,${0.35*p})`);
  ctx.fillStyle=vig;
  ctx.fillRect(0,0,W,H);
}

function loop(){
  draw();
  requestAnimationFrame(loop);
}
requestAnimationFrame(loop);
