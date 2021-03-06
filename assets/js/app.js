/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.scss in this case)
const $ = require('jquery');
require('../css/app.scss');


// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
require('../../node_modules/materialize-css/dist/js/materialize');


import AOS from 'aos'
import 'aos/dist/aos.css'

AOS.init();
