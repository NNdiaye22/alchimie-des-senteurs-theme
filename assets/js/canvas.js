const cv  = document.getElementById('c');
const ctx = cv.getContext('2d');
let W, H, dpr;

function resize() {
  dpr = Math.min(window.devicePixelRatio||1,2);
  W   = window.innerWidth;
  H   = window.innerHeight;
  cv.width  = W*dpr; cv.height = H*dpr;
  cv.style.width = W+'px'; cv.style.height = H+'px';
  ctx.setTransform(dpr,0,0,dpr,0,0);
}
resize();
window.addEventListener('resize', resize);

// ─── Scroll ───────────────────────────────────────────────────────────
let sp = 0, targetSP = 0;
function rawP() {
  const sc = document.getElementById('scroll-zone');
  return Math.min(Math.max(window.scrollY/(sc.offsetHeight - H), 0), 1);
}
window.addEventListener('scroll', () => {
  targetSP = rawP();
  document.getElementById('pbar').style.width = (targetSP*100)+'%';
  document.getElementById('nav').classList.toggle('scrolled', window.scrollY>80);
}, {passive:true});

// ─── LERP smooth like Apple ────────────────────────────────────────────────────
function lerp(a,b,t){return a+(b-a)*t;}

// ─── ENCENS GEOMETRY ──────────────────────────────────────────────────────────────────────────────────
const STICKR    = 7;
const STICKFULL = 640;

// ─── Fumée ─────────────────────────────────────────────────────────────────────────────────────────────
class SmokeParticle {
  constructor() { this.reset(true); }
  reset(init=false) {
    const sz = Math.min(W,H);
    this.x    = 0;
    this.y    = init ? -Math.random()*sz*0.6 : 0;
    this.vx   = Math.random()*1.3 - 0.5;
    this.vy   = -(Math.random()*1.2 + 0.5);
    this.r    = Math.random()*40 + 20;
    this.life = 1;
    this.decay= Math.random()*0.004 + 0.0012;
    this.sway = Math.random()*Math.PI*2;
    this.swayS= Math.random()*0.006 + 0.002;
    this.grow = Math.random()*0.25 + 0.08;
    this.alpha= Math.random()*0.06 + 0.015;
  }
  update(p,t) {
    this.sway += this.swayS;
    this.x += this.vx * Math.sin(this.sway) * 0.7;
    this.y += this.vy * (0.6 + p*1.2);
    this.r += this.grow * (0.5 + p*0.8);
    this.life -= this.decay * (0.5 + p);
    if(this.life <= 0) this.reset();
  }
  draw(ctx, tipX, tipY, p) {
    const a = this.alpha * this.life * Math.min(p*8, 1);
    if(a < 0.003) return;
    const grd = ctx.createRadialGradient(tipX+this.x, tipY+this.y, 0, tipX+this.x, tipY+this.y, this.r);
    grd.addColorStop(0,   `rgba(160,145,130,${a})`);
    grd.addColorStop(0.4, `rgba(180,165,148,${a*0.5})`);
    grd.addColorStop(1,   `rgba(200,190,178,0)`);
    ctx.beginPath();
    ctx.arc(tipX+this.x, tipY+this.y, this.r, 0, Math.PI*2);
    ctx.fillStyle = grd;
    ctx.fill();
  }
}

class Ember {
  constructor() { this.reset(); this.x=0; this.y=0; }
  reset() {
    this.vx   = Math.random()*3 - 0.5;
    this.vy   = -(Math.random()*2 + 0.5);
    this.life = 1;
    this.decay= Math.random()*0.02 + 0.008;
    this.r    = Math.random()*1.8 + 0.4;
  }
  update(p) {
    this.vy += 0.04;
    this.x += this.vx; this.y += this.vy;
    this.life -= this.decay;
    if(this.life <= 0) this.reset();
  }
  draw(ctx, tx, ty, p) {
    const a = this.life * 0.9 * Math.min(p*10, 1);
    if(a < 0.01) return;
    ctx.beginPath();
    ctx.arc(tx+this.x, ty+this.y, this.r, 0, Math.PI*2);
    ctx.fillStyle = `rgba(220,140,60,${a})`;
    ctx.fill();
  }
}

const smokes = Array.from({length:55}, () => new SmokeParticle());
const embers = Array.from({length:18}, () => new Ember());

// ─── Draw Incense ──────────────────────────────────────────────────────────────────────────────────────────
function drawIncense(p, t) {
  const cx = W*0.5;
  const cy = H*0.5;
  const sz = Math.min(W,H);
  const scale = Math.min(sz*0.0012, 1.2);

  const rotAngle = p * Math.PI * 1.8 + Math.PI * 0.15;
  const cosA = Math.cos(rotAngle);
  const sinA = Math.sin(rotAngle);

  const consumed = p * 0.72;
  const stickLen = STICKFULL * (1 - consumed * 0.85);
  const ashLen   = STICKFULL * consumed * 0.85;

  const tiltX = Math.sin(t*0.00058);
  const tiltY = Math.cos(t*0.00065);

  const tipY3d    = -stickLen/2 - ashLen/2;
  const bottomY3d =  stickLen/2 + ashLen/2;
  const tipScreenX = cx + tiltX;
  const tipScreenY = cy + tipY3d*scale + tiltY;
  const botScreenX = cx + tiltX;
  const botScreenY = cy + bottomY3d*scale + tiltY;

  // Ombre
  const shadowY = botScreenY + 30*scale;
  const shadowW = STICKR*8 * Math.abs(cosA) * STICKFULL*0.1*scale;
  const oshGrd = ctx.createRadialGradient(cx, shadowY, 0, cx, shadowY, shadowW);
  oshGrd.addColorStop(0, 'rgba(26,23,20,0.08)');
  oshGrd.addColorStop(1, 'rgba(26,23,20,0)');
  ctx.beginPath();
  ctx.ellipse(cx, shadowY, shadowW, shadowW*0.12, 0, 0, Math.PI*2);
  ctx.fillStyle = oshGrd;
  ctx.fill();

  // Cendre
  if(ashLen > 0) {
    const ashTopY  = cy + tipY3d*scale + tiltY;
    const ashBotY  = ashTopY + ashLen*scale;
    const ashW     = STICKR*scale * Math.max(Math.abs(cosA)*0.9+0.1, 0.12);
    const ashWFull = STICKR*scale * (1+Math.abs(sinA)*0.15);
    const ashGrd = ctx.createLinearGradient(0, ashTopY, 0, ashBotY);
    ashGrd.addColorStop(0,   'rgba(210,205,198,0.95)');
    ashGrd.addColorStop(0.4, 'rgba(195,188,180,0.9)');
    ashGrd.addColorStop(1,   'rgba(180,172,163,0.85)');
    ctx.beginPath();
    ctx.ellipse(cx+tiltX, ashTopY, ashWFull, ashW*0.35, 0, 0, Math.PI*2);
    ctx.fillStyle = 'rgba(215,210,203,0.9)';
    ctx.fill();
    ctx.beginPath();
    ctx.moveTo(cx+tiltX - ashWFull, ashTopY);
    ctx.lineTo(cx+tiltX - ashW,     ashBotY);
    ctx.lineTo(cx+tiltX + ashW,     ashBotY);
    ctx.lineTo(cx+tiltX + ashWFull, ashTopY);
    ctx.closePath();
    ctx.fillStyle = ashGrd;
    ctx.fill();
    // Jonction cendre/bâtonnet
    const jY = ashBotY;
    const jGrd = ctx.createLinearGradient(cx-ashW, 0, cx+ashW, 0);
    jGrd.addColorStop(0,   'rgba(196,135,58,0)');
    jGrd.addColorStop(0.5, `rgba(220,130,50,${Math.min(consumed*3, 0.9)})`);
    jGrd.addColorStop(1,   'rgba(196,135,58,0)');
    ctx.beginPath();
    ctx.ellipse(cx+tiltX, jY, ashW*1.2, ashW*0.4, 0, 0, Math.PI*2);
    ctx.fillStyle = jGrd;
    ctx.fill();
  }

  // Bâtonnet
  const bTopY  = cy + tipY3d*scale + ashLen*scale + tiltY;
  const bBotY  = botScreenY;
  const bW     = STICKR*scale * (1+Math.abs(sinA)*0.15);
  const bWside = STICKR*scale * Math.max(Math.abs(cosA)*0.9+0.1, 0.12);
  const lightX = cx+tiltX - bW*0.35;
  const darkX  = cx+tiltX + bW;
  const stickGrd = ctx.createLinearGradient(lightX-bW, 0, darkX+bW, 0);
  stickGrd.addColorStop(0,   'rgba(60,48,38,0.85)');
  stickGrd.addColorStop(0.2, 'rgba(80,63,48,0.9)');
  stickGrd.addColorStop(0.45,'rgba(110,88,68,0.95)');
  stickGrd.addColorStop(0.6, 'rgba(85,67,52,0.9)');
  stickGrd.addColorStop(0.8, 'rgba(55,44,35,0.85)');
  stickGrd.addColorStop(1,   'rgba(35,28,22,0.8)');
  ctx.beginPath();
  ctx.moveTo(cx+tiltX - bW,     bTopY);
  ctx.lineTo(cx+tiltX - bWside, bBotY);
  ctx.lineTo(cx+tiltX + bWside, bBotY);
  ctx.lineTo(cx+tiltX + bW,     bTopY);
  ctx.closePath();
  ctx.fillStyle = stickGrd;
  ctx.fill();
  // Reflet
  const specX = cx+tiltX - bW*0.3;
  const specGrd = ctx.createLinearGradient(specX-2, bTopY, specX+2, bTopY);
  specGrd.addColorStop(0,   'rgba(255,255,255,0)');
  specGrd.addColorStop(0.5, `rgba(255,255,255,${0.12*(1-consumed)})`);
  specGrd.addColorStop(1,   'rgba(255,255,255,0)');
  ctx.fillStyle = specGrd;
  ctx.fillRect(specX-2, bTopY, 4, bBotY-bTopY);
  ctx.beginPath();
  ctx.ellipse(cx+tiltX, bBotY, bWside, bWside*0.32, 0, 0, Math.PI*2);
  ctx.fillStyle = 'rgba(40,32,25,0.7)';
  ctx.fill();
  ctx.beginPath();
  ctx.ellipse(cx+tiltX, bTopY, bW, bWside*0.32, 0, 0, Math.PI*2);
  ctx.fillStyle = 'rgba(50,40,32,0.5)';
  ctx.fill();

  // Braise
  const brW    = bW*1.1;
  const braseY = bTopY;
  const glowR  = (60*scale*0.6) * (Math.sin(t*0.009)*0.4+0.6);
  const glowA  = (0.5*Math.sin(t*0.009)+0.5) * Math.min(consumed*5+0.1, 1);
  const glowGrd = ctx.createRadialGradient(cx+tiltX, braseY, 0, cx+tiltX, braseY, glowR);
  glowGrd.addColorStop(0,   `rgba(240,160,60,${glowA*0.25})`);
  glowGrd.addColorStop(0.4, `rgba(200,100,30,${glowA*0.1})`);
  glowGrd.addColorStop(1,   'rgba(200,100,30,0)');
  ctx.globalCompositeOperation = 'screen';
  ctx.beginPath();
  ctx.arc(cx+tiltX, braseY, glowR, 0, Math.PI*2);
  ctx.fillStyle = glowGrd;
  ctx.fill();
  ctx.globalCompositeOperation = 'source-over';
  const brGrd = ctx.createRadialGradient(cx+tiltX, braseY, 0, cx+tiltX, braseY, brW*1.5);
  brGrd.addColorStop(0,   `rgba(255,200,80,${glowA*0.95})`);
  brGrd.addColorStop(0.3, `rgba(230,130,40,${glowA*0.7})`);
  brGrd.addColorStop(0.7, `rgba(180,80,20,${glowA*0.3})`);
  brGrd.addColorStop(1,   'rgba(180,80,20,0)');
  ctx.beginPath();
  ctx.arc(cx+tiltX, braseY, brW*1.5, 0, Math.PI*2);
  ctx.fillStyle = brGrd;
  ctx.fill();

  // Fumée & étincelles
  smokes.forEach(s => { s.update(p,t); s.draw(ctx, cx+tiltX, bTopY, p); });
  embers.forEach(e => { e.update(p);   e.draw(ctx, cx+tiltX, braseY, p); });

  return { tipX: cx+tiltX, tipY: bTopY };
}

// ─── Background ─────────────────────────────────────────────────────────────────────────────────────────────
function drawBg(p, t) {
  ctx.fillStyle = '#ffffff';
  ctx.fillRect(0,0,W,H);
  if(p > 0.05) {
    const cx = W/2, cy = H*0.5;
    const grd = ctx.createRadialGradient(cx,cy,0, cx,cy, Math.min(W,H)*0.7);
    grd.addColorStop(0,   `rgba(250,240,228,${p*0.35})`);
    grd.addColorStop(0.5, `rgba(248,244,238,${p*0.1})`);
    grd.addColorStop(1,   'rgba(255,255,255,0)');
    ctx.fillStyle = grd;
    ctx.fillRect(0,0,W,H);
  }
}

// ─── UI ───────────────────────────────────────────────────────────────────────────────────────────────────
function updateUI(p) {
  const a = Math.min(p/0.07, 1);
  const ot = document.getElementById('ot');
  ot.style.opacity = a;
  ot.style.transform = `translateY(${(1-a)*10}px)`;
  const oT = document.getElementById('oT');
  oT.style.opacity = a;
  oT.style.transform = `translateY(${(1-a)*18}px)`;
  const ol = document.getElementById('ol');
  ol.style.width = (a*80)+'px';
  const os = document.getElementById('os');
  os.style.opacity = a;
  os.style.transform = `translateY(${(1-a)*10}px)`;

  // Hero fade out
  if(p > 0.1) {
    const fadeA = Math.max(1 - (p-0.1)/0.1, 0);
    ['ot','oT','ol','os'].forEach(id => {
      document.getElementById(id).style.opacity = Math.min(fadeA, a);
    });
  }

  // Info blocks
  const IL = document.getElementById('info-left');
  const IR = document.getElementById('info-right');
  const IB = document.getElementById('info-bottom');
  const showInfo = p > 0.38 && p < 0.68;
  IL.classList.toggle('vis', showInfo);
  IR.classList.toggle('vis', showInfo);
  IB.classList.toggle('vis', p > 0.55 && p < 0.72);

  // Phase copies
  const pcs = [
    {id:'pc1', s:0.15, e:0.36},
    {id:'pc2', s:0.40, e:0.60},
    {id:'pc3', s:0.64, e:0.84},
  ];
  pcs.forEach(({id,s,e}) => {
    const el = document.getElementById(id);
    const v  = p>=s && p<=e ? Math.min((p-s)/0.05,1)*Math.min((e-p)/0.05,1) : 0;
    el.style.opacity = v;
  });

  // Cue
  document.getElementById('cue').style.opacity = Math.max(1-p*14, 0);
}

// ─── Loop ─────────────────────────────────────────────────────────────────────────────────────────────────────
let st = null;
function loop(ts) {
  if(!st) st=ts;
  const t = ts-st;
  sp = lerp(sp, targetSP, 0.08);
  drawBg(sp, t);
  drawIncense(sp, t);
  updateUI(sp);
  requestAnimationFrame(loop);
}
requestAnimationFrame(loop);

// Smooth nav links
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const t = document.querySelector(a.getAttribute('href'));
    if(t){ e.preventDefault(); t.scrollIntoView({behavior:'smooth'}); }
  });
});
