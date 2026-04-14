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

let sp = 0, targetSP = 0;
function rawP() {
  const sc = document.getElementById('scroll-zone');
  return Math.min(Math.max(window.scrollY/(sc.offsetHeight - H), 0), 1);
}
window.addEventListener('scroll',()=>{
  targetSP = rawP();
  document.getElementById('pbar').style.width = (targetSP*100)+'%';
  document.getElementById('nav').classList.toggle('scrolled', window.scrollY>80);
},{passive:true});

function lerp(a,b,t){return a+(b-a)*t;}

const STICK_R    = 7;
const STICK_FULL = 640;

class SmokeParticle {
  constructor(){ this.reset(true); }
  reset(init=false){
    const sz = Math.min(W,H);
    this.x  = 0;
    this.y  = init ? -(Math.random()*sz*0.6) : 0;
    this.vx = (Math.random()-0.5)*0.8;
    this.vy = -(Math.random()*1.2+0.5);
    this.r  = Math.random()*40+20;
    this.life = 1;
    this.decay= Math.random()*0.004+0.0012;
    this.sway = Math.random()*Math.PI*2;
    this.swayS= Math.random()*0.006+0.002;
    this.grow = Math.random()*0.25+0.08;
    this.alpha= Math.random()*0.06+0.015;
  }
  update(p,t){
    this.sway+=this.swayS;
    this.x += this.vx+Math.sin(this.sway)*0.7;
    this.y += this.vy*(0.6+p*1.2);
    this.r  += this.grow*(0.5+p*0.8);
    this.life-=this.decay*(0.5+p);
    if(this.life<=0) this.reset();
  }
  draw(ctx, tipX, tipY, p){
    const a=this.alpha*this.life*Math.min(p*8,1);
    if(a<0.003) return;
    const grd=ctx.createRadialGradient(
      tipX+this.x, tipY+this.y, 0,
      tipX+this.x, tipY+this.y, this.r
    );
    grd.addColorStop(0,  `rgba(160,145,130,${a})`);
    grd.addColorStop(0.4,`rgba(180,165,148,${a*0.5})`);
    grd.addColorStop(1,  'rgba(200,190,178,0)');
    ctx.beginPath();
    ctx.arc(tipX+this.x, tipY+this.y, this.r, 0, Math.PI*2);
    ctx.fillStyle=grd;
    ctx.fill();
  }
}

class Ember {
  constructor(){this.reset();}
  reset(){
    this.x=0;this.y=0;
    this.vx=(Math.random()-0.5)*2.5;
    this.vy=-(Math.random()*2+0.5);
    this.life=1;
    this.decay=Math.random()*0.02+0.008;
    this.r=Math.random()*1.8+0.4;
  }
  update(p){
    this.vy+=0.04;
    this.x+=this.vx;this.y+=this.vy;
    this.life-=this.decay;
    if(this.life<=0) this.reset();
  }
  draw(ctx,tx,ty,p){
    const a=this.life*0.9*Math.min(p*10,1);
    if(a<0.01) return;
    ctx.beginPath();
    ctx.arc(tx+this.x,ty+this.y,this.r,0,Math.PI*2);
    ctx.fillStyle=`rgba(220,140,60,${a})`;
    ctx.fill();
  }
}

const smokes = Array.from({length:55},()=>new SmokeParticle());
const embers = Array.from({length:18},()=>new Ember());

function drawIncense(p, t) {
  const cx = W*0.5;
  const cy = H*0.5;
  const sz = Math.min(W,H);
  const scale = Math.min(sz*0.0012, 1.2);
  const rotAngle = p * Math.PI * 1.8 + Math.PI * 0.15;
  const cosA = Math.cos(rotAngle);
  const sinA = Math.sin(rotAngle);
  const consumed = p * 0.72;
  const stickLen = STICK_FULL * (1 - consumed * 0.85);
  const ashLen   = STICK_FULL * consumed * 0.85;
  const tiltX = Math.sin(t*0.0005)*8;
  const tiltY = Math.cos(t*0.0006)*5;
  const tipY3d   = -stickLen/2 - ashLen/2;
  const bottomY3d= stickLen/2  + ashLen/2;
  const tipScreenX = cx + tiltX;
  const tipScreenY = cy + tipY3d*scale + tiltY;
  const botScreenX = cx + tiltX;
  const botScreenY = cy + bottomY3d*scale + tiltY;

  const shadowY = botScreenY + 30*scale;
  const shadowW = (STICK_R*8 + Math.abs(cosA)*STICK_FULL*0.1)*scale;
  const oshGrd = ctx.createRadialGradient(cx,shadowY,0,cx,shadowY,shadowW);
  oshGrd.addColorStop(0,'rgba(26,23,20,0.08)');
  oshGrd.addColorStop(1,'rgba(26,23,20,0)');
  ctx.beginPath();
  ctx.ellipse(cx,shadowY,shadowW,shadowW*0.12,0,0,Math.PI*2);
  ctx.fillStyle=oshGrd;
  ctx.fill();

  if(ashLen>0){
    const ashTopY = cy + tipY3d*scale + tiltY;
    const ashBotY = ashTopY + ashLen*scale;
    const ashW    = STICK_R*scale*Math.max(Math.abs(cosA)*0.9+0.1,0.12);
    const ashWFull= STICK_R*scale*(1+Math.abs(sinA)*0.15);
    const ashGrd = ctx.createLinearGradient(0,ashTopY,0,ashBotY);
    ashGrd.addColorStop(0,'rgba(210,205,198,0.95)');
    ashGrd.addColorStop(0.4,'rgba(195,188,180,0.9)');
    ashGrd.addColorStop(1,'rgba(180,172,163,0.85)');
    ctx.beginPath();
    ctx.ellipse(cx+tiltX, ashTopY, ashWFull, ashW*0.35, 0, 0, Math.PI*2);
    ctx.fillStyle='rgba(215,210,203,0.9)';
    ctx.fill();
    ctx.beginPath();
    ctx.moveTo(cx+tiltX-ashWFull, ashTopY);
    ctx.lineTo(cx+tiltX-ashW, ashBotY);
    ctx.lineTo(cx+tiltX+ashW, ashBotY);
    ctx.lineTo(cx+tiltX+ashWFull, ashTopY);
    ctx.closePath();
    ctx.fillStyle=ashGrd;
    ctx.fill();
    const jY=ashBotY;
    const jGrd=ctx.createLinearGradient(cx-ashW,0,cx+ashW,0);
    jGrd.addColorStop(0,'rgba(196,135,58,0)');
    jGrd.addColorStop(0.5,`rgba(220,130,50,${Math.min(consumed*3,0.9)})`);
    jGrd.addColorStop(1,'rgba(196,135,58,0)');
    ctx.beginPath();
    ctx.ellipse(cx+tiltX,jY,ashW*1.2,ashW*0.4,0,0,Math.PI*2);
    ctx.fillStyle=jGrd;
    ctx.fill();
  }

  const bTopY = cy + (tipY3d+ashLen)*scale + tiltY;
  const bBotY = botScreenY;
  const bW    = STICK_R*scale*(1+Math.abs(sinA)*0.15);
  const bWside= STICK_R*scale*Math.max(Math.abs(cosA)*0.9+0.1, 0.12);
  const lightX = cx + tiltX - bW*0.35;
  const darkX  = cx + tiltX + bW;
  const stickGrd = ctx.createLinearGradient(lightX-bW, 0, darkX+bW, 0);
  stickGrd.addColorStop(0,   'rgba(60,48,38,0.85)');
  stickGrd.addColorStop(0.2, 'rgba(80,63,48,0.9)');
  stickGrd.addColorStop(0.5, 'rgba(110,88,65,0.95)');
  stickGrd.addColorStop(0.75,'rgba(85,67,50,0.9)');
  stickGrd.addColorStop(1,   'rgba(55,43,33,0.85)');
  ctx.beginPath();
  ctx.moveTo(cx+tiltX-bW, bTopY);
  ctx.lineTo(cx+tiltX-bWside, bBotY);
  ctx.lineTo(cx+tiltX+bWside, bBotY);
  ctx.lineTo(cx+tiltX+bW, bTopY);
  ctx.closePath();
  ctx.fillStyle=stickGrd;
  ctx.fill();

  ctx.beginPath();
  ctx.ellipse(cx+tiltX, bBotY, bW*1.05, bWside*0.4, 0, 0, Math.PI*2);
  ctx.fillStyle='rgba(45,35,27,0.7)';
  ctx.fill();

  ctx.beginPath();
  ctx.ellipse(cx+tiltX, bTopY, bW, bWside*0.35, 0, 0, Math.PI*2);
  const tipCapGrd = ctx.createRadialGradient(cx+tiltX-bW*0.2, bTopY, 0, cx+tiltX, bTopY, bW);
  tipCapGrd.addColorStop(0, 'rgba(130,105,80,0.9)');
  tipCapGrd.addColorStop(1, 'rgba(60,47,35,0.85)');
  ctx.fillStyle=tipCapGrd;
  ctx.fill();

  const specGrd=ctx.createLinearGradient(cx+tiltX-bW*0.2,bTopY,cx+tiltX-bW*0.2,bBotY);
  specGrd.addColorStop(0,'rgba(255,255,255,0.08)');
  specGrd.addColorStop(0.3,'rgba(255,255,255,0.04)');
  specGrd.addColorStop(1,'rgba(255,255,255,0)');
  ctx.beginPath();
  ctx.moveTo(cx+tiltX-bW*0.55, bTopY);
  ctx.lineTo(cx+tiltX-bW*0.5, bBotY);
  ctx.lineTo(cx+tiltX-bW*0.1, bBotY);
  ctx.lineTo(cx+tiltX-bW*0.15, bTopY);
  ctx.closePath();
  ctx.fillStyle=specGrd;
  ctx.fill();

  const tipX = cx+tiltX;
  const tipY = bTopY;
  const brasGrd=ctx.createRadialGradient(tipX,tipY,0,tipX,tipY,bW*2.5*Math.min(p*5+0.3,1));
  brasGrd.addColorStop(0,`rgba(255,180,60,${0.9*Math.min(p*5+0.15,1)})`);
  brasGrd.addColorStop(0.3,`rgba(220,110,30,${0.6*Math.min(p*4+0.1,1)})`);
  brasGrd.addColorStop(0.6,`rgba(180,70,20,${0.2*Math.min(p*3,1)})`);
  brasGrd.addColorStop(1,'rgba(140,50,10,0)');
  ctx.beginPath();
  ctx.arc(tipX,tipY,bW*2.5*Math.min(p*5+0.3,1),0,Math.PI*2);
  ctx.fillStyle=brasGrd;
  ctx.fill();

  smokes.forEach(s=>s.draw(ctx,tipX,tipY,p));
  embers.forEach(e=>e.draw(ctx,tipX,tipY,p));
}

function drawBG(p) {
  // Fond toujours blanc — pas de degradé sombre
  ctx.fillStyle = '#ffffff';
  ctx.fillRect(0, 0, W, H);
}

function showOverlay(p) {
  const show = p < 0.08;
  const els = [
    {el:document.getElementById('ot'), delay:0},
    {el:document.getElementById('oT'), delay:0.05},
    {el:document.getElementById('ol'), delay:0.1},
    {el:document.getElementById('os'), delay:0.15},
  ];
  els.forEach(({el,delay})=>{
    if(!el) return;
    const v = show ? 1 : 0;
    el.style.opacity = v;
    el.style.transform = show ? 'translateY(0)' : (el.id==='ol' ? '' : 'translateY(-8px)');
    if(el.id==='ol') el.style.width = show ? '80px' : '0';
  });

  const cue = document.getElementById('cue');
  if(cue) cue.style.opacity = p < 0.04 ? 1 : 0;

  // Info blocks
  const infoShow = p > 0.15 && p < 0.38;
  ['info-left','info-right','info-bottom'].forEach(id=>{
    const el = document.getElementById(id);
    if(el) el.classList.toggle('vis', infoShow);
  });

  // Phase copies
  const pc1 = document.getElementById('pc1');
  const pc2 = document.getElementById('pc2');
  const pc3 = document.getElementById('pc3');
  if(pc1) pc1.style.opacity = (p > 0.38 && p < 0.54) ? 1 : 0;
  if(pc2) pc2.style.opacity = (p > 0.54 && p < 0.70) ? 1 : 0;
  if(pc3) pc3.style.opacity = (p > 0.70 && p < 0.86) ? 1 : 0;
}

let t = 0;
function loop() {
  requestAnimationFrame(loop);
  sp = lerp(sp, targetSP, 0.06);
  t++;
  smokes.forEach(s=>s.update(sp,t));
  embers.forEach(e=>e.update(sp));
  drawBG(sp);
  drawIncense(sp, t);
  showOverlay(sp);
}
loop();

// Entrée hero au chargement
window.addEventListener('load', ()=>{
  setTimeout(()=>{
    const ot = document.getElementById('ot');
    const oT = document.getElementById('oT');
    const ol = document.getElementById('ol');
    const os = document.getElementById('os');
    if(ot){ot.style.opacity='1';ot.style.transform='translateY(0)';}
    if(oT){oT.style.opacity='1';oT.style.transform='translateY(0)';}
    if(ol){ol.style.width='80px';ol.style.opacity='1';}
    if(os){os.style.opacity='1';os.style.transform='translateY(0)';}
    const cue = document.getElementById('cue');
    if(cue) cue.style.opacity='1';
  }, 400);
});