<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
  </head>
  <style>
    .container {
      width: 100%;
      height: 100%;
      height: 100vh;
      overflow: hidden !important;
    }

    h1 {
      font-family: "Source Sans Pro", sans-serif;
      font-weight: bold;
      font-size: 80px;
      letter-spacing: 20px;
      text-transform: uppercase;
      text-align: center;
      color: #cdcdcd;
      margin: 0px;
      padding: 0 0 20px 0;
      text-shadow: -3px 0 0 rgba(255, 0, 0, 0.7), 3px 0 0 rgba(0, 255, 255, 0.7);
      pointer-events: none;
    }

    h2 {
      font-family: "Source Sans Pro", sans-serif;
      font-size: 30px;
      font-weight: 600;
      letter-spacing: 10px;
      text-transform: uppercase;
      text-align: center;
      color: #cdcdcd;
      line-height: 50px;
      padding: 0px;
      margin: 0px;
      /* text-shadow: -3px 0 0 rgba(255, 0, 0, 0.7), 3px 0 0 rgba(0, 255, 255, 0.7); */
      pointer-events: none;
    }

    h2 a {
      color: #cdcdcd;
      text-decoration: none;
      border-bottom: 5px solid #cdcdcd;
      margin: 0;
      padding: 0;
      pointer-events:initial;
    }

    h2 a span {
      letter-spacing: 0px !important;
      padding-right: 2px;
    }

    h2 a:hover {
      color: #aaa;
      border-bottom: 5px solid #aaa;
    }

    #scene ul {
      width: 100% !important;
      height: 100% !important;
      height: 100vh !important;
      overflow: hidden;
      position: relative;
    }

    .text {
      position: relative;
      top: 50%;
      -webkit-transform: translateY(-50%) !important;
      -ms-transform: translateY(-50%) !important;
      transform: translateY(-50%) !important;
      z-index: 3;
      display: block;
    }

    /* ---- reset ---- */

    body {
      margin: 0;
      font: normal 75% Arial, Helvetica, sans-serif;
    }

    canvas {
      display: block;
    }

    /* ---- particles.js container ---- */

    #particles-js {
      position: absolute;
      width: 100%;
      height: 100%;
      background-color: #222;
      background-image: url("");
      background-repeat: no-repeat;
      background-size: cover;
      background-position: 50% 50%;
    }
  </style>

  <body>
    <div id="particles-js">
      <canvas class="particles-js-canvas-el" style="width: 100%; height: 100%">
      </canvas>
    </div>

    <div class="container">
      <div class="text">
        <h1>
          ERROR 404
        </h1>
        <h2>
          Go <a href="/dinas/">hom<span>e</span></a>&nbsp; Page Not Found
        </h2>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
      /*inspired from : https://codepen.io/ArielBeninca/pen/yyKaPX
  Particle JS - Vincent Garreau
  */
      particlesJS("particles-js", {
        particles: {
          number: {
            value: 80,
            density: {
              enable: true,
              value_area: 800,
            },
          },
          color: { value: "#ffffff" },
          shape: {
            type: "circle",
            stroke: {
              width: 0,
              color: "#000000",
            },
            polygon: { nb_sides: 5 },
            image: {
              src: "img/github.svg",
              width: 100,
              height: 100,
            },
          },
          opacity: {
            value: 0.5,
            random: false,
            anim: {
              enable: false,
              speed: 1,
              opacity_min: 0.1,
              sync: false,
            },
          },
          size: {
            value: 3,
            random: true,
            anim: {
              enable: false,
              speed: 40,
              size_min: 0.1,
              sync: false,
            },
          },
          line_linked: {
            enable: true,
            distance: 150,
            color: "#ffffff",
            opacity: 0.4,
            width: 1,
          },
          move: {
            enable: true,
            speed: 3,
            direction: "none",
            random: false,
            straight: false,
            out_mode: "out",
            bounce: false,
            attract: {
              enable: false,
              rotateX: 600,
              rotateY: 1200,
            },
          },
        },
        interactivity: {
          detect_on: "canvas",
          events: {
            onhover: {
              enable: true,
              mode: "grab",
            },
            onclick: {
              enable: true,
              mode: "push",
            },
            resize: true,
          },
          modes: {
            grab: {
              distance: 140,
              line_linked: { opacity: 1 },
            },
            bubble: {
              distance: 400,
              size: 40,
              duration: 2,
              opacity: 8,
              speed: 3,
            },
            repulse: {
              distance: 200,
              duration: 0.4,
            },
            push: { particles_nb: 4 },
            remove: { particles_nb: 2 },
          },
        },
        retina_detect: true,
      });
    </script>
  </body>
</html>