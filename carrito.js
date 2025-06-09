// Vaciar Carrito
const vaciarBtn = document.getElementById("vaciarBtn");
if (vaciarBtn) {
  vaciarBtn.addEventListener("click", () => {
    fetch("vaciar-carrito.php")
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          document.querySelector(".carrito-productos").innerHTML = `
            <div class="alert alert-info alert-dismissible fade show" role="alert">
              🧺 Tu carrito ha sido vaciado correctamente.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
          `;
          document.getElementById("contadorCarrito").innerText = "0";
        }
      });
  });
}

// Carrito Panel
const abrirCarritoBtn = document.getElementById("abrirCarrito");
const cerrarCarritoBtn = document.getElementById("cerrarCarrito");
const carritoPanel = document.getElementById("carritoPanel");

abrirCarritoBtn?.addEventListener("click", () => {
  carritoPanel.classList.add("open");
});

cerrarCarritoBtn?.addEventListener("click", () => {
  carritoPanel.classList.remove("open");
});

document.addEventListener("click", function (e) {
  if (!carritoPanel.contains(e.target) && !abrirCarritoBtn.contains(e.target)) {
    carritoPanel.classList.remove("open");
  }
});

// Para la seccion de te podria interesar de la pagina detalle-producto
document.querySelectorAll('.btn-agregar-carrito').forEach(boton => {
  boton.addEventListener('click', () => {
    const id = boton.getAttribute('data-id');
    agregarAlCarrito(id);
  });
});


// Contador carrito
function actualizarContadorCarrito() {
  fetch("carrito-contador.php")
    .then((res) => res.json())
    .then((data) => {
      const contador = document.getElementById("contadorCarrito");
      if (data.total > 0) {
        contador.textContent = data.total;
        contador.style.display = "inline";
      } else {
        contador.style.display = "none";
      }
    });
}

// Modificar cantidad carrito
function modificarCantidad(idProducto, cambio) {
  fetch("modificar-cantidad.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `id=${idProducto}&cambio=${cambio}`,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        actualizarCarrito();
      }
    });
}

// Actualizar carrito
function actualizarCarrito() {
  fetch("carrito-contenido.php")
    .then((res) => res.text())
    .then((html) => {
      document.getElementById("contenedorCarrito").innerHTML = html;
      asignarEventosCarrito();
      actualizarContadorCarrito();
    });
}

// Eventos carrito
function asignarEventosCarrito() {
  const vaciarBtn = document.getElementById("vaciarBtn");
  if (vaciarBtn) {
    vaciarBtn.addEventListener("click", () => {
      // Mostrar mensaje inmediatamente
      document.getElementById("contenedorCarrito").innerHTML = `
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    🧺 Tu carrito ha sido vaciado correctamente.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            `;
      document.getElementById("contadorCarrito").innerText = "0";

      // Hacer petición para vaciar en backend
      fetch("vaciar-carrito.php")
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            setTimeout(() => {
              actualizarCarrito();
            }, 800);
          }
        });
    });
  }
}

// Agregar carrito
function agregarAlCarrito(idProducto, boton) {
  fetch("agregar-carrito.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: "id=" + encodeURIComponent(idProducto),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        mostrarMensaje("✅ Producto agregado al carrito");
        actualizarCarrito();
      } else {
        mostrarMensaje("❌ Hubo un error al agregar el producto");
      }
    })
    .catch(() => {
      mostrarMensaje("⚠️ Error de red");
    });
}

function mostrarMensaje(texto) {
  const alert = document.createElement("div");
  alert.className = "alert alert-success position-fixed top-0 end-0 m-3";
  alert.style.zIndex = "1050";
  alert.innerText = texto;
  document.body.appendChild(alert);
  setTimeout(() => alert.remove(), 3000);
}

document.addEventListener("DOMContentLoaded", () => {
  actualizarContadorCarrito();
  asignarEventosCarrito();
});
