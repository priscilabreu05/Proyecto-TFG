document.addEventListener('DOMContentLoaded', () => {
  const carritoBtn = document.querySelector('.carrito-boton');
  
  carritoBtn.addEventListener('click', () => {
    alert('¡Tu carrito está vacío! 😅');
  });
});
