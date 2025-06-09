import React, { useEffect, useState } from 'react';
import { Routes, Route, Navigate } from 'react-router-dom';
import Login from './pages/Login';
import Register from './pages/Register';

function App() {
  const [usuario, setUsuario] = useState(null);

  useEffect(() => {
    const datos = localStorage.getItem('usuario');
    if (datos) {
      setUsuario(JSON.parse(datos));
    }
  }, []);

  const cerrarSesion = () => {
    localStorage.removeItem('usuario');
    setUsuario(null);
  };

  return (
    <>
      <Routes>
        <Route path="/" element={usuario ? <Navigate to="/bienvenida" /> : <Navigate to="/login" />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/bienvenida" element={
          usuario ? (
            <div className="bienvenida">
              <h1>Bienvenido/a, {usuario.nombre}</h1>
              <a href="http://localhost/tfg-proyecto-final/index.php">Ir a la tienda</a>
              <br />
              <button onClick={cerrarSesion}>Cerrar sesión</button>
            </div>
          ) : (
            <Navigate to="/login" />
          )
        } />
      </Routes>
    </>
  );
}

export default App;
