<?php 

/**
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 * Copyright (C) 2008,2009 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS.
 *
 * Wolf CMS is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Wolf CMS is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Wolf CMS.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Wolf CMS has made an exception to the GNU General Public License for plugins.
 * See exception.txt for details and the full text.
 */

/**
 * @package wolf
 * @subpackage controllers
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @version 0.1
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * @copyright Philippe Archambault, 2008
 */

/**
 * Allows a user to access login/logout related functionality.
 *
 * It also has functionality to email a new password to the user if that user
 * cannot remember his or her password.
 *
 * @package wolf
 * @subpackage controllers
 *
 * @version 0.1
 * @since 0.1
 */
class LoginController extends Controller {
/**
 * Sets up the LoginController.
 */
    function __construct() {
        // Redirect to HTTPS for login purposes if requested
        if (defined('USE_HTTPS') && USE_HTTPS && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on")) {
            $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            header("Location: $url");
            exit;
        }

        AuthUser::load();
    }

    /**
     * Checks if a user is already logged in, otherwise it redirects the user
     * to the login screen.
     */
    function index() {
    // already log in ?
        if (AuthUser::isLoggedIn()) {
            if (Flash::get('redirect') != null)
                redirect(Flash::get('redirect'));
            else
                redirect(get_url());
        }

        // show it!
        $this->display('login/login', array(
            'username' => Flash::get('username'),
            'redirect' => Flash::get('redirect')
        ));
    }

    /**
     * Allows a user to login.
     */
    function login() {
    // already log in ?
        if (AuthUser::isLoggedIn())
            if (Flash::get('redirect') != null)
                redirect(Flash::get('redirect'));
            else
                redirect(get_url());

        if (get_request_method() == 'POST') {
            $data = isset($_POST['login']) ? $_POST['login']: array('username' => '', 'password' => '');
            Flash::set('username', $data['username']);

            if (AuthUser::login($data['username'], $data['password'], isset($data['remember']))) {
                Observer::notify('admin_login_success', $data['username']);

                $this->_checkVersion();
                // redirect to defaut controller and action
                if ($data['redirect'] != null && $data['redirect'] != 'null')
                    redirect($data['redirect']);
                else
                    redirect(get_url());
            }
            else {
                Flash::set('error', __('Login failed. Please check your login data and try again.'));
                Observer::notify('admin_login_failed', $data['username']);
            }
        }

        // not find or password is wrong
        if ($data['redirect'] != null && $data['redirect'] != 'null')
            redirect($data['redirect']);
        else
            redirect(get_url('login'));

    }

    /**
     * Allows a user to logout.
     */
    function logout() {
        $username = AuthUser::getUserName();
        AuthUser::logout();
        Observer::notify('admin_after_logout', $username);
        redirect(get_url());
    }

    /**
     * Allows a user to request a new password be mailed to him/her.
     *
     * @return <type> ???
     */
    function forgot() {
        if (get_request_method() == 'POST')
            return $this->_sendPasswordTo($_POST['forgot']['email']);

        $this->display('login/forgot', array('email' => Flash::get('email')));
    }

    /**
     * This method is used to send a newly generated password to a user.
     *
     * @param string $email The user's email adress.
     */
    private function _sendPasswordTo($email) {
        $user = User::findBy('email', $email);
        if ($user) {
            use_helper('Email');

            $new_pass = '12'.dechex(rand(100000000, 4294967295)).'K';
            $user->password = sha1($new_pass);
            $user->save();

            $email = new Email();
            $email->from(Setting::get('admin_email'), Setting::get('admin_title'));
            $email->to($user->email);
            $email->subject('Your new password from '.Setting::get('admin_title'));
            $email->message('username: '.$user->username."\npassword: ".$new_pass);
            $email->send();

            Flash::set('success', 'An email has been send with your new password!');
            redirect(get_url('login'));
        }
        else {
            Flash::set('email', $email);
            Flash::set('error', 'No user found!');
            redirect(get_url('login/forgot'));
        }
    }

    /**
     * Checks what the latest Wolf version is that is available at wolfcms.org
     *
     * @todo Make this check optional through the configuration file
     */
    private function _checkVersion() {
        if (!defined('CHECK_UPDATES') || !CHECK_UPDATES)
            return;

        $v = getContentFromUrl('http://www.wolfcms.org/version/');

        if (false !== $v && $v > CMS_VERSION) {
            Flash::set('error', __('<b>Information!</b> New Wolf version available (v. <b>:version</b>)! Visit <a href="http://www.wolfcms.org/">http://www.wolfcms.org/</a> to upgrade your version!',
                array(':version' => $v )));
        }
    }

} // end LoginController class
