<?php

use App\PetController;
use App\UserController;
use App\ValidationController;
use Entity\Pet;
use Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Utility\SimpleImage;

$petController = new PetController();
$validation = new ValidationController();
$userController = new UserController();
/*
 *
 * ERROR ROUTES
 *
 */
$app->error(function (\Exception $e, Request $request, $code) use ($app) {

    switch ($code) {
        case 404:

            return $app['twig']->render('errors/error404.html.twig');
            break;
        default:
            return $app['twig']->render('errors/error.html.twig');
    }

});
/*
 *
 * HOME ROUTES
 *
 */
$app->get('/', function () use ($app) {
    return $app->redirect("/home");
});

$app->get('/home', function () use ($app) {
    $user = $app['session']->get('user');


    return $app['twig']->render('pages/homepage.html.twig', [
        'user' => $user
    ]);
});

/*
 *
 * REGISTRATION ROUTES
 *
 */
$app->get('/registration', function () use ($app) {
    return $app['twig']->render('pages/registration.html.twig', ['errors' => []]);
});

/*
$app->post('/registration', function (Request $request) use ($app) {
    $validation = new ValidationController();


    $errors = array();
    $validRequest = $validation->validateRegistration($request, $errors);

    if ($validRequest) {
        $registration = new UserController();
        $registration->registerUserFromRegistrationRequest($request);
        return $app->redirect('/auth');
    } else {
        return $app['twig']->render('pages/registration.html.twig', ['errors' => $errors]);
    }

    $password = md5($request->request->get("password"));
    $name = $request->request->get("name");
    $email = $request->request->get("email");
    $password2 = md5($request->request->get("password2"));

    if (!($validation->isSamePasswords($password, $password2))) {
        $errors[] = 'your passwords not same';
    }

    if ($validation->isExistingUser($email)) {
        $errors[] = 'this user exist';
    }

    if (!empty($errors)) {

    }

    $user = new User($name, $email, $password);

});
*/
$app->post('/registration', function (Request $request) use ($userController, $validation, $app) {

    $errors = array();
    $password = md5($request->request->get("password"));
    $name = $request->request->get("name");
    $email = $request->request->get("email");
    $password2 = md5($request->request->get("password2"));

    if (!($validation->isSamePasswords($password, $password2))) {
        $errors[] = 'your passwords not same';
    }

    if ($validation->isExistingUser($email)) {
        $errors[] = 'this user exist';
    }

    if (!empty($errors)) {
        return $app['twig']->render('pages/registration.html.twig', ['errors' => $errors]);
    }

    $user = new User($name, $email, $password);
    $userController->register($user);
    return $app->redirect('/auth');
});
/*
 *
 * AUTHENTICATION ROUTES
 *
 */
$app->post('/auth', function (Request $request) use ($userController, $validation, $app) {
    $errors = array();
    $password = md5($request->request->get("password"));
    $email = $request->request->get("email");

    if (!($validation->isExistingUser($email))) {
        $errors[] = 'this user not exist, please reg you';
    }

    if (($validation->isCorrectPasswordForCorrectEmail($email, $password)) === false) {
        $errors[] = 'not correct password';
    }

    if (!empty($errors  )) {

        return $app['twig']->render('pages/authentication.html.twig', ['errors' => $errors]);
    }
    $user = $userController->getUserByEmail($email);
    $app['session']->set('user', $user);
    return $app['twig']->render('pages/homepage.html.twig', ['user' => $user]);
});
$app->get('/auth', function () use ($app) {

    return $app['twig']->render('pages/authentication.html.twig', ['errors' => []]);

});

$app->get('/pets', function () use ($petController, $app) {
    $user = $app['session']->get('user');

    $petsAll = $petController->getAllPet();
    $pets = array();
    for ($i = 0; $i < count($petsAll); $i++) {
        if (($petsAll[$i]["status"]) == 0) {
            $pets[] = $petsAll[$i];
        }
    }
    return $app['twig']->render('pages/pets.html.twig', ['pets' => $pets, 'user' => $user]);

});
/*
 *
 * /PETS/WITH_USER ROUTES
 *
 */
$app->get('/pets/with_user', function () use ($petController, $app) {
    $user = $app['session']->get('user');

    $petsAll = $petController->getAllPet();
    $pets = array();
    for ($i = 0; $i < count($petsAll); $i++) {
        if (($petsAll[$i]["status"]) == 1) {
            $pets[] = $petsAll[$i];
        }
    }
    return $app['twig']->render('pages/petsWithUser.html.twig', ['pets' => $pets, 'user' => $user]);

});
/*
 *
 * /PETS/TAKE/{} ROUTES
 *
 */
$app->post('/pets/take/{id}', function (Request $request, $id) use ($app, $petController) {
    $user = $app['session']->get('user');
    $petController->updatePetStatus($id, 1);
    $petController->setPetUser($id, $user['id']);
    return $app->redirect('/your_pets');
});
/*
 *
 * /YOUR_PETS ROUTES
 *
 */
$app->get('/your_pets', function () use ($petController, $app) {
    $user = $app['session']->get('user');
    $idUser = $user['id'];
    $pets = $petController->getPetByUserId($idUser);
    return $app['twig']->render('pages/personal.html.twig', ['user' => $user, 'pets' => $pets]);

});
/*
 *
 * /PET/ADD ROUTES
 *
 */
$app->get('/pets/add', function () use ($app) {
    $user = $app['session']->get('user');
    return $app['twig']->render('pages/add.html.twig', ['user' => $user]);
});

$app->post('/pets/add', function (Request $request) use ($app, $petController) {
    $name = $request->request->get("pet_name");
    $breed = $request->request->get("pet_breed");
    $sex = $request->request->get("sex");
    $description = $request->request->get("pet_description");
    $disease = $request->request->get("pet_disease");
    $age = $request->request->get("pet_age");
    $filename = $_FILES['pet_img']['tmp_name'];
    $imageName = null;

    switch (exif_imagetype($filename)) {
        case IMAGETYPE_JPEG:
            $imageName = uniqid("", false) . '.jpeg';
            break;

        case IMAGETYPE_GIF:
            $imageName = uniqid("", false) . '.gif';
            break;

        case IMAGETYPE_PNG:
            $imageName = uniqid("", false) . '.png';
            break;

    }

    move_uploaded_file($filename, UPLOAD_PATH . $imageName);

    $pet = new Pet($name, $sex, 0, $description, $age, '/tmp/img/pets/' . $imageName, $breed, $disease);
    $petController->addPet($pet);

    $user = $app['session']->get('user');

    $petsAll = $petController->getAllPet();
    $pets = array();
    for ($i = 0; $i < count($petsAll); $i++) {
        if (($petsAll[$i]["status"]) == 0) {
            $pets[] = $petsAll[$i];
        }
    }
    return $app['twig']->render('pages/pets.html.twig', ['pets' => $pets, 'user' => $user]);

//    $app->redirect('/pets');
});
/*
 *
 * /PETS/DELETE{} ROUTES
 *
 */
$app->post('/pets/delete/{id}', function (Request $request, $id) use ($app, $petController) {

    $petController->deletePet($id);

    return $app->redirect('/pets');
});
/*
 *
 * LOGOUT ROUTES
 *
 */
$app->get('/logout', function (Request $request) use ($app) {
    $session = $request->getSession();
    $session->clear();
    return $app['twig']->render('pages/homepage.html.twig', ['user' => null]);
});
/*
 *
 * /PETS/REFUSE/{}
 *
 */
$app->post('/pets/refuse/{id}', function (Request $request, $id) use ($app, $petController) {
    $user = $app['session']->get('user');
    $petController->updatePetStatus($id, 0);
    $petController->setPetUser($id, 0);
    return $app->redirect('/your_pets');
});