/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

import '/node_modules/bootstrap/dist/css/bootstrap.css'

// start the Stimulus application
import './bootstrap';

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

let span = document.querySelectorAll("span");

if (span) {
    // each letter changes color and font style when hovering the mouse over a label
    let color = ['blue', 'red', 'yellow', 'orange', 'green', 'black', 'brown', 'gray', 'brown', 'blueviolet', 'coral', 'pink'];
    let font = ['bold', 'normal'];

    document.getElementById("titleLibrary").addEventListener("mouseover",letterColorAndFont);

    function letterColorAndFont () {
        let time = 500;
        for (let x = 0; x < span.length; x++) {
            setTimeout(function () {
                let randomColor = color[Math.floor(Math.random() * color.length)];
                let randomFont = font[Math.floor(Math.random() * font.length)];
                span[x].style.color = randomColor;
                span[x].style.fontWeight = randomFont;
                span[x].style.fontStyle = "italic";
                span[x].style.fontSize = "50px";
            }, time);
            time = time + 500;
        }
    }
}

if(document.getElementById("alert")) {
    setTimeout(
        function () {
            document.getElementById("alert").style.display = "none";
        }
    , 5000);
}