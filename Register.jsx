import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import logo from '../assets/logo-tfg-removebg-preview.png';

function Register() {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    nombre: '',
    apellidos: '',
    email: '',
    telefono: '',
    password: '',
    confirmPassword: '',
  });

  const [errors, setErrors] = useState({
    telefono: '',
    password: '',
  });

  const validateInputs = () => {
    let valid = true;
    const newErrors = { telefono: '', password: '' };

    if (!/^\d{9}$/.test(formData.telefono)) {
      newErrors.telefono = 'El teléfono debe tener exactamente 9 dígitos.';
      valid = false;
    }

    if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.#_-])[A-Za-z\d@$!%*?&.#_-]{8,}$/.test(formData.password)) {
      newErrors.password ='La contraseña debe tener al menos 8 caracteres, incluyendo mayúscula, minúscula, número y carácter especial.';
      valid = false;
    }

    if (formData.password !== formData.confirmPassword) {
      newErrors.confirmPassword = 'Las contraseñas no coinciden.';
      valid = false;
    }

    setErrors(newErrors);
    return valid;
  };

  const handleRegister = async (e) => {
    e.preventDefault();

    if (!validateInputs()) return;

    try {
      const res = await fetch('http://localhost/tfg-proyecto-final/registro-usuario.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData),
      });

      const data = await res.json();

      if (data.success) {
        alert('Registro exitoso');
        navigate('/login');
      } else {
        alert(data.message || 'Error al crear la cuenta');
      }
    } catch (err) {
      alert('Error al conectar con el servidor');
      console.error(err);
    }
  };

   const handleChange = (e) => {
    setFormData((prev) => ({
      ...prev,
      [e.target.name]: e.target.value,
    }));
    setErrors((prev) => ({ ...prev, [e.target.name]: '' }));
  };

  return (
    <>
      <div className="register-container">
        <header className="header">
        <a href="http://localhost/tfg-proyecto-final/index.php">
          <img src={logo} alt="Pam Accessories" className="logo" />
        </a>
      </header>
        <div className="register-right">
          <form onSubmit={handleRegister}>
            <h2>Crear Cuenta</h2>
            <input name="nombre" placeholder="Nombre" required onChange={handleChange} value={formData.nombre} />
            <input name="apellidos" placeholder="Apellidos" required onChange={handleChange} value={formData.apellidos} />
            <input name="email" type="email" placeholder="Correo electrónico" required onChange={handleChange} value={formData.email} />
            <input name="telefono" type='tel' placeholder="Teléfono" required onChange={handleChange} value={formData.telefono} />
            {errors.telefono && <p style={{ color: 'red', fontSize: '0.9em' }}>{errors.telefono}</p>}

            <input name="password" type="password" placeholder="Contraseña" required onChange={handleChange} value={formData.password} />
            {errors.password && <p style={{ color: 'red', fontSize: '0.9em' }}>{errors.password}</p>}

            <input type="password" name="confirmPassword" placeholder="Confirmar contraseña" value={formData.confirmPassword} onChange={handleChange} required/>
            {errors.confirmPassword && <p className="error">{errors.confirmPassword}</p>}

            <button type="submit">Registrarse</button>
            <p className="enlace-login">
                ¿Ya tienes una cuenta?{' '}
              <span onClick={() => navigate('/login')} style={{ color: 'blue', cursor: 'pointer' }}>
                Volver a Iniciar Sesión
              </span>
            </p>
          </form>
        </div>
      </div>
    </>
  );
}

export default Register;
