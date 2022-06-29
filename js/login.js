// $('login').click(() => {
//   var username = $('username')
//   var password = $('password')
//   var url = '../ajax/validation-login.php'

//   $.ajax({
//     url: url,
//     data: {
//       username: username,
//       password: password
//     },
//     accepts: 'application/json',
//     method: 'POST',
//     //error
//   })
//   .done((data)=>{
//     $.each(data, (index,item) => {
//       item.username = "vedrowjee"
//       alert('hi ved')
//     })
//   })

// })

$('#login').click((e)=>{
  e.preventDefault()
  var username = $('#username').val()
  var password = $('#password').val()
  $.ajax({
    url: "ajax/login.php",
    type: "POST",
    data: ({
      username: username,
      password: password
    }),
    dataType: 'text',
    success: (data)=>{
      if(data == "OK"){
        window.location.href = "dashboard.php";
      }
      else if(data == "NOT-ADMIN"){
        alert('User is not an admin')
      }
      else if(data == "WRONG-CREDENTIAL"){
        alert('Username or password incorrect')
      }
      else{
        alert('An error occurred')
      }
    }
  })
})


// toggle visibility of passwords
$("#checkbox").click(function () {
  var x = document.querySelector("#password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
});

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
