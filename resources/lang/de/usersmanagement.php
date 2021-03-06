<?php

return [

    // Titles
    'showing-all-users'     => 'Showing All Users',
    'users-menu-alt'        => 'Show Users Management Menu',
    'create-new-user'       => 'Create New User',
    'show-deleted-users'    => 'Show Deleted User',
    'editing-user'          => 'Editing User :name',
    'showing-user'          => 'Showing User :name',
    'showing-user-title'    => ':name\'s Information',

    // Flash Messages
    'createSuccess'   => 'Benutzer wurde erfolgreich erstellt!',
    'updateSuccess'   => 'Benutzer wurde erfolgreich aktualisiert!',
    'deleteSuccess'   => 'Benutzer wurde erfolgreich gelöscht!',
    'deleteSelfError' => 'Du kannst dich nicht selber Löschen!',

    // Show User Tab
    'viewProfile'            => 'Profil ansehen',
    'editUser'               => 'Benutzer editieren',
    'deleteUser'             => 'Benutzer löschen',
    'usersBackBtn'           => 'Zurück zum den Benutzern',
    'usersPanelTitle'        => 'Benutzer Informationen',
    'labelUserName'          => 'Pfadiname:',
    'labelFirstName'         => 'Vorname:',
    'labelLastName'          => 'Nachname:',
    'labelRole'              => 'Rolle:',
    'labelStatus'            => 'Status:',
    'labelAccessLevel'       => 'Zugriffe',
    'labelPermissions'       => 'Berechtigungen:',
    'labelCreatedAt'         => 'Erstellt am:',
    'labelUpdatedAt'         => 'Aktualisiert am:',
    'labelIpEmail'           => 'Email Registrierungs IP:',
    'labelIpEmail'           => 'Email Anmelde IP:',
    'labelIpConfirm'         => 'Bestätigungs IP:',
    'labelIpSocial'          => 'Socialite Anmelde IP:',
    'labelIpAdmin'           => 'Admin Anmelde IP:',
    'labelIpUpdate'          => 'Latztes Update IP:',
    'labelDeletedAt'         => 'Gelöscht am',
    'labelIpDeleted'         => 'Gelöscht IP:',
    'usersDeletedPanelTitle' => 'Gelöscht Benutzer Information',
    'usersBackDelBtn'        => 'Zurück zu den gelöschten Benutzern',

    'successRestore'    => 'Benutzer erfolgreich wiederhergestellt.',
    'successDestroy'    => 'Benutzer erfolgreich entfernt.',
    'errorUserNotFound' => 'Benutzer wurde nicht gefunden.',

    'labelUserLevel'  => 'Level',
    'labelUserLevels' => 'Level',

    'users-table' => [
        'caption'   => '{1} :userscount user total|[2,*] :userscount total users',
        'id'        => 'ID',
        'name'      => 'Name',
        'email'     => 'Email',
        'role'      => 'Role',
        'created'   => 'Created',
        'updated'   => 'Updated',
        'actions'   => 'Actions',
        'updated'   => 'Updated',
    ],

    'buttons' => [
        'create-new'    => '<span class="hidden-xs hidden-sm">New User</span>',
        'delete'        => '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  <span class="hidden-xs hidden-sm">Delete</span><span class="hidden-xs hidden-sm hidden-md"> User</span>',
        'show'          => '<i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Show</span><span class="hidden-xs hidden-sm hidden-md"> User</span>',
        'edit'          => '<i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Edit</span><span class="hidden-xs hidden-sm hidden-md"> User</span>',
        'back-to-users' => '<span class="hidden-sm hidden-xs">Back to </span><span class="hidden-xs">Users</span>',
        'back-to-user'  => 'Back  <span class="hidden-xs">to User</span>',
        'delete-user'   => '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  <span class="hidden-xs">Delete</span><span class="hidden-xs"> User</span>',
        'edit-user'     => '<i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs">Edit</span><span class="hidden-xs"> User</span>',
    ],

    'tooltips' => [
        'delete'        => 'Delete',
        'show'          => 'Show',
        'edit'          => 'Edit',
        'create-new'    => 'Create New User',
        'back-users'    => 'Back to users',
        'email-user'    => 'Email :user',
        'submit-search' => 'Submit Users Search',
        'clear-search'  => 'Clear Search Results',
    ],

    'messages' => [
        'userNameTaken'          => 'Username is taken',
        'userNameRequired'       => 'Username is required',
        'fNameRequired'          => 'First Name is required',
        'lNameRequired'          => 'Last Name is required',
        'emailRequired'          => 'Email is required',
        'emailInvalid'           => 'Email is invalid',
        'passwordRequired'       => 'Password is required',
        'PasswordMin'            => 'Password needs to have at least 6 characters',
        'PasswordMax'            => 'Password maximum length is 20 characters',
        'captchaRequire'         => 'Captcha is required',
        'CaptchaWrong'           => 'Wrong captcha, please try again.',
        'roleRequired'           => 'User role is required.',
        'user-creation-success'  => 'Successfully created user!',
        'update-user-success'    => 'Successfully updated user!',
        'delete-success'         => 'Successfully deleted the user!',
        'cannot-delete-yourself' => 'You cannot delete yourself!',
    ],

    'show-user' => [
        'id'                => 'User ID',
        'name'              => 'Username',
        'email'             => '<span class="hidden-xs">User </span>Email',
        'role'              => 'User Role',
        'created'           => 'Created <span class="hidden-xs">at</span>',
        'updated'           => 'Updated <span class="hidden-xs">at</span>',
        'labelRole'         => 'User Role',
        'labelAccessLevel'  => '<span class="hidden-xs">User</span> Access Level|<span class="hidden-xs">User</span> Access Levels',
    ],

    'search'  => [
        'title'             => 'Showing Search Results',
        'found-footer'      => ' Record(s) found',
        'no-results'        => 'No Results',
        'search-users-ph'   => 'Search Users',
    ],

    'modals' => [
        'delete_user_message' => 'Are you sure you want to delete :user?',
    ],
];
