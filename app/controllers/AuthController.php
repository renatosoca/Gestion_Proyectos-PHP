<?php

namespace App\Controllers;

use App\Router;
use App\Models\User;
use App\Utils\Email;

class AuthController {

  public static function AuthUser() {
    session_start();
    $alerts = [];
    $tempUser = new User();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $tempUser = new User($_POST);
      $alerts = $tempUser->userValidate();

      if (empty($alerts)) {
        $user = User::findOne('email', $tempUser->email);

        if (!$user) return User::setAlert('error', 'No hay ningún usuario registrado con ese email');
        if (!$user->verifyPassword($tempUser->password)) return User::setAlert('error', 'Email o contraseña incorrectos');
        if (!$user->hasVerifiedEmail) return User::setAlert('error', 'Debes verificar tu email antes de iniciar sesión');
        
        $_SESSION['userId'] = $user->id;
        $_SESSION['name'] = $user->name;
        $_SESSION['lastname'] = $user->lastname;
        $_SESSION['email'] = $user->email;
        $_SESSION['login'] = true;
        
        Router::redirect('/dashboard');
      }
    }

    $alerts = User::getAlerts();

    Router::render('auth/login', 'AuthLayout', [
      'title' => 'Iniciar sesión',
      'alerts' => $alerts,
      'user' => $tempUser,
    ]);

    exit;
  }

  public static function createUser() {
    $isAuth = isAuth();
    if ($isAuth) Router::redirect('/dashboard');

    $user = new User();
    $alerts = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user->synchronize($_POST);
      $alerts = $user->validateData();

      if (empty($alerts)) {
        $userExist = User::findOne('email', $user->email);

        if ($userExist) return User::setAlert('error', 'Ya existe un usuario registrado con ese email');

        $user->hashPassword();
        $user->generateToken();

        $mail = new Email($user->email, $user->name, $user->lastname, $user->token);
        $response = $mail->SendMail(
          'registerUser',
          'Registro de usuario',
          'Confirmar cuenta',
          $_ENV['HOST'] . "/confirm-account/" . $user->token,
        );

        if ( $response ) {
          $user->save();
          
          Router::redirect('/message');
        }

        User::setAlert('error', 'Ha ocurrido un error al crear tu cuenta, por favor intenta nuevamente');
      }
    }

    $alerts = User::getAlerts();
    
    Router::render('auth/register', 'AuthLayout', [
      'title' => 'Registro de usuario',
      'user' => $user,
      'alerts' => $alerts,
    ]);

    exit;
  }

  public static function confirmAccount( string $token = '') {
    $isAuth = isAuth();
    if ($isAuth) Router::redirect('/dashboard');
    
    $alerts = [];
    $token = sanitize($token);
    $isVerified = false;
    $user = User::findOne('token', $token);

    if (empty($user)) User::setAlert('error', 'El token es inválido o ya ha sido utilizado');
    if ($user && $user->hasVerifiedEmail) User::setAlert('error', "El correo electrónico: {$user->email} ya ha sido verificado anteriormente");

    if (!empty($user) && !$user->hasVerifiedEmail) {
      $user->hasVerifiedEmail = true;
      $user->token = '';
      
      $user->save();

      $isVerified = true;

      User::setAlert('success', 'Tu cuenta ha sido verificada correctamente');
    }

    $alerts = User::getAlerts();

    Router::render('auth/confirmAccount', 'AuthLayout', [
      'title' => 'Confirmar cuenta',
      'alerts' => $alerts,
      'isVerified' => $isVerified,
    ]);

    exit;
  }

  public static function forgotPassword() {
    $alerts = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user = new User($_POST);
      $alerts = $user->validateEmail();

      if (empty($alerts)) {
        $user = User::findOne('email', $user->email);

        if (!$user) return User::setAlert('error', 'No hay ningún usuario registrado con ese email');
        if (!$user->hasVerifiedEmail) return User::setAlert('error', 'Debes verificar tu email antes de reestablecer tu contraseña');
        
        $user->generateToken();

        $mail = new Email($user->email, $user->name, $user->lastname, $user->token);
        $response = $mail->SendMail(
          'forgotPassword', 
          'Recuperar contraseña',
          'Reestablecer contraseña',
          $_ENV['HOST'] . "/reset-password/" . $user->token,
        );

        if ( $response ) {
          $user->save();
          
          User::setAlert('success', 'Hemos enviado las instrucciones a tu Email');
          return;
        }

        User::setAlert('error', 'Ha ocurrido un error al generar el token, por favor intenta nuevamente');
      }
    }

    $alerts = User::getAlerts();

    Router::render('auth/forgotPassword', 'AuthLayout', [
      'title' => 'Recuperar contraseña',
      'alerts' => $alerts,
    ]);

    exit;
  }

  public static function reserPassword( string $token = '') {
    $alerts = [];
    $token = sanitize($token);
    $error = false;

    $user = User::findOne('token', $token);
    if (!$user) {
      $error = true;
      User::setAlert('error', 'El token es inválido');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$error) {
      $tempUser = new User($_POST);
      $alerts = $tempUser->validatePassword();

      if (empty($alerts)) {
        $user->password = $tempUser->password;
        $user->hashPassword();
        $user->token = '';
        
        //Send Mail

        $user->save();

        Router::redirect('/');
      }
    }

    $alerts = User::getAlerts();

    Router::render('auth/resetPassword', 'AuthLayout', [
      'title' => 'Nueva contraseña',
      'alerts' => $alerts,
      'error' => $error,
    ]);

    exit;
  }

  public static function profile() {
    isAuth();

    $alerts = [];
    $user = User::findOne( 'id', $_SESSION['userId']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user->synchronize($_POST);
      $alerts = $user->userValidate();

      if (empty( $alerts )) {
        $userExist = User::findOne('email', $user->email);

        if ($userExist && $userExist->id !== $user->id) return User::setAlert('error', 'El correo no está disponible');

        $response = $user->save();

        if ($response) {
          $_SESSION['name'] = $user->name;

          User::setAlert('exito', 'Actualizado correctamente');
        }
      }
    }

    $alerts = User::getAlerts();

    Router::render('dashboard/profile', 'ProjectLayout', [
      'title' => 'Perfil',
      'name' => $_SESSION['name'] ?? '',
      'alerts' => $alerts,
      'user' => $user
    ]);
  }

  public static function changePassword() {
    isAuth();
    $alertas = [];
    $user = User::findOne( 'id', $_SESSION['userId']);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $tempUser = new User($_POST);
      $alertas = $tempUser->validateNewPassword();

      if (empty( $alertas )) {
        $result = $user->verifyPassword($tempUser->currentPassword);

        if ( !$result ) return User::setAlert('error', 'Contraseña actual es incorrecta');
        
        $user->password = $tempUser->password;

        $user->hashPassword();
        $response = $user->save();
        
        if ($response) return User::setAlert('exito', 'Actualizado Correctamente');
      }
    }

    $alertas = User::getAlerts();
    
    Router::render('dashboard/changePassword', 'ProjectLayout', [
      'title' => 'Cambiar Contraseña',
      'name' => $_SESSION['name'] ?? '',
      'alerts' => $alertas,
      'user' => $user
    ]);

    exit;
  }
}