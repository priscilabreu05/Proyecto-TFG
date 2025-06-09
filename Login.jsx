import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import logo from "../assets/logo-tfg-removebg-preview.png";

function Login({ setUsuario }) {
  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const handleLogin = async (e) => {
    e.preventDefault();

    try {
      const res = await fetch("http://localhost/tfg-proyecto-final/login.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        credentials: "include", // MUY IMPORTANTE para mantener la sesión con cookies
        body: JSON.stringify({ email, password }),
      });

      const text = await res.text();
      console.log("Respuesta del servidor:", text);

      const data = JSON.parse(text);

      if (data.success) {
        // Guardar usuario en localStorage (para usarlo en favoritos, etc.)
        localStorage.setItem("usuario", JSON.stringify(data.usuario));

        if (setUsuario) {
          setUsuario(data.usuario);
        }

        const encodedNombre = encodeURIComponent(data.usuario.nombre);
        window.location.href = `http://localhost/tfg-proyecto-final/index.php?nombre=${encodedNombre}`;
      } else {
        alert(data.message || "Credenciales incorrectas");
      }
    } catch (err) {
      alert("Error al conectar con el servidor");
      console.error("Error de conexión:", err);
    }
  };

  return (
    <>
      {/* HEADER CON LOGO */}
      <header className="header">
        <a href="http://localhost/tfg-proyecto-final/index.php">
          <img src={logo} alt="Pam Accessories" className="logo" />
        </a>
      </header>

      {/* TÍTULO */}
      <h1 className="main-title">INICIA SESIÓN O CREA TU CUENTA</h1>

      {/* CONTENIDO DIVIDIDO */}
      <div className="container">
        <div className="left">
          <div className="content-box">
            <h2>¿No tienes cuenta?</h2>
            <p>Regístrate para comprar los mejores accesorios.</p>
            <button onClick={() => navigate("/register")}>Crear Cuenta</button>
          </div>
        </div>
        <div className="right">
          <div className="content-box">
            <form onSubmit={handleLogin}>
              <h2>Iniciar Sesión</h2>
              <input
                type="email"
                placeholder="Correo electrónico"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                required
              />
              <input
                type="password"
                placeholder="Contraseña"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
              />
              <button type="submit">Entrar</button>
            </form>
          </div>
        </div>
      </div>
    </>
  );
}

export default Login;
