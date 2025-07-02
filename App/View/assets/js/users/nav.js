document.addEventListener('DOMContentLoaded',()=>{
  const ham=document.getElementById('hamburger');
  const links=document.getElementById('nav-links');
  if(!ham||!links) return;
  ham.addEventListener('click',()=>{
    links.classList.toggle('open');
  });
}); 