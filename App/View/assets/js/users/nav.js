document.addEventListener('DOMContentLoaded',()=>{
  const ham=document.getElementById('hamburger');
  const links=document.getElementById('nav-links');
  if(!ham||!links) return;
  
  // Garantir que o menu sempre comece fechado
  links.classList.remove('open');
  
  ham.addEventListener('click',()=>{
    links.classList.toggle('open');
  });
  
  // Fechar menu ao clicar em um link
  const menuLinks = links.querySelectorAll('a');
  menuLinks.forEach(link => {
    link.addEventListener('click', () => {
      links.classList.remove('open');
    });
  });
}); 