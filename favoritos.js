function actualizarContadorFavoritos() {
  fetch("contador-favoritos.php")
    .then((res) => res.text())
    .then((conteo) => {
      const el = document.getElementById("contadorFavoritos");
      if (el) el.innerText = conteo;
    });
}

function mostrarMensajeFavorito(msg) {
  const alerta = document.createElement("div");
  alerta.className =
    "alert alert-success position-fixed top-0 end-0 m-3 shadow fade show";
  alerta.role = "alert";
  alerta.innerHTML = msg;
  document.body.appendChild(alerta);
  setTimeout(() => alerta.remove(), 3000);
}

document.addEventListener("DOMContentLoaded", function () {
  document.addEventListener("click", function (e) {
    const btn = e.target.closest(".favorito-toggle-btn");
    if (!btn) return;

    e.preventDefault();
    const id = btn.dataset.id;
    const img = btn.querySelector(".icon-heart");

    fetch("http://localhost/tfg-proyecto-final/toggle-favorito.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      credentials: "include",
      body: "id=" + encodeURIComponent(id),
    })
      .then((res) => res.json())
      .then((data) => {
        const nuevoSrc = data.favorito
          ? "http://localhost/tfg-proyecto-final/assets/img/heart-filled.png"
          : "http://localhost/tfg-proyecto-final/assets/img/heart.png";

        img.src = nuevoSrc;
        btn.dataset.favorito = data.favorito ? "1" : "0";

        mostrarMensajeFavorito(
          data.favorito ? "💖 Añadido a favoritos" : "💔 Eliminado de favoritos"
        );

        actualizarContadorFavoritos();
      })
      .catch((err) => {
        console.error("Error al cambiar favorito:", err);
      });
  });

  // Siempre cargar los favoritos desde sesión, con o sin login
  fetch("http://localhost/tfg-proyecto-final/favoritos.php", {
    credentials: "include",
    headers: {
      Accept: "application/json",
    },
  })
    .then((res) => res.json())
    .then((favoritos) => {
      console.log("Favoritos actuales:", favoritos);
    });
});
