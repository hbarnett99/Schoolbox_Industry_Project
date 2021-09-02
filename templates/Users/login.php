<?php
    // $this->disableAutoLayout();
?>

<!DOCTYPE html>
<html lang="en">

<body class="g-sidenav-show  bg-gray-100">
  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-95 pt-5 pb-11 m-3 border-radius-lg login-backsplash">
      <span class="mask bg-gradient-dark opacity-2"></span>
      <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 text-center mx-auto">
                <h1 class="text-white mb-2 mt-5">Schoolbox Server Health</h1>
<!--                <p class="text-lead text-white">Schoolbox</p>-->
            </div>
            <div class="container">
                <div class="">
                    <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                        <div class="card z-index-0 ">
                            <div class="card-header text-center pt-4">
                                <?= $this->Html->image('../favicon.ico', ['class' => 'img-fluid']); ?>
<!--                                <h5>Login with Google</h5>-->
                            </div>
                            <div class="row px-xl-5 px-sm-4 px-3">

                                <!-- OFFICIAL GOOGLE BUTTON -->
                                <div id="my-signin2"></div>

                                <!-- ATTEMPTED CONVERSION OF TEMPLATE TO PHP -->
                                <?php
                                echo $this->Form->postLink(
                                    $this->Html->Image('google_logo.svg'), ['escape' => false],
                                    ['class' => 'nav-link active btn btn-outline-light w-100 bg-white',
                                        'escape' => false,
                                        'prefix' => false,
                                        'plugin' => 'ADmad/SocialAuth',
                                        'controller' => 'Auth',
                                        'action' => 'login',
                                        'provider' => 'google',
                                        '?' => ['redirect' => $this->request->getQuery('redirect')]
                                    ],
                                    [
                                        'escape' => false
                                    ]
                                );
                                ?>

                                <!-- DANE'S IMAGE IMPLEMENTATION -->
                                <?php
                                //            echo $this->Form->postLink(
                                //                $this->Html->Image('google_logo.svg', ['style' => 'width: 30px; margin-bottom:0px!important']),
                                //                [
                                //                    'prefix' => false,
                                //                    'plugin' => 'ADmad/SocialAuth',
                                //                    'controller' => 'Auth',
                                //                    'action' => 'login',
                                //                    'provider' => 'google',
                                //                    '?' => ['redirect' => $this->request->getQuery('redirect')]
                                //                ],
                                //                [
                                //                    'escape' => false
                                //                ]
                                //            );
                                ?>

                                <!-- TEMPLATE G BUTTON -->
<!--                                <div class="col-3 me-auto px-1">-->
<!--                                    <a class="btn btn-outline-light w-100" href="javascript:">-->
<!--                                        <svg width="24px" height="32px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">-->
<!--                                            <g id="Artboard" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">-->
<!--                                                <g id="google-icon" transform="translate(3.000000, 2.000000)" fill-rule="nonzero">-->
<!--                                                    <path d="M57.8123233,30.1515267 C57.8123233,27.7263183 57.6155321,25.9565533 57.1896408,24.1212666 L29.4960833,24.1212666 L29.4960833,35.0674653 L45.7515771,35.0674653 C45.4239683,37.7877475 43.6542033,41.8844383 39.7213169,44.6372555 L39.6661883,45.0037254 L48.4223791,51.7870338 L49.0290201,51.8475849 C54.6004021,46.7020943 57.8123233,39.1313952 57.8123233,30.1515267" id="Path" fill="#4285F4"></path>-->
<!--                                                    <path d="M29.4960833,58.9921667 C37.4599129,58.9921667 44.1456164,56.3701671 49.0290201,51.8475849 L39.7213169,44.6372555 C37.2305867,46.3742596 33.887622,47.5868638 29.4960833,47.5868638 C21.6960582,47.5868638 15.0758763,42.4415991 12.7159637,35.3297782 L12.3700541,35.3591501 L3.26524241,42.4054492 L3.14617358,42.736447 C7.9965904,52.3717589 17.959737,58.9921667 29.4960833,58.9921667" id="Path" fill="#34A853"></path>-->
<!--                                                    <path d="M12.7159637,35.3297782 C12.0932812,33.4944915 11.7329116,31.5279353 11.7329116,29.4960833 C11.7329116,27.4640054 12.0932812,25.4976752 12.6832029,23.6623884 L12.6667095,23.2715173 L3.44779955,16.1120237 L3.14617358,16.2554937 C1.14708246,20.2539019 0,24.7439491 0,29.4960833 C0,34.2482175 1.14708246,38.7380388 3.14617358,42.736447 L12.7159637,35.3297782" id="Path" fill="#FBBC05"></path>-->
<!--                                                    <path d="M29.4960833,11.4050769 C35.0347044,11.4050769 38.7707997,13.7975244 40.9011602,15.7968415 L49.2255853,7.66898166 C44.1130815,2.91684746 37.4599129,0 29.4960833,0 C17.959737,0 7.9965904,6.62018183 3.14617358,16.2554937 L12.6832029,23.6623884 C15.0758763,16.5505675 21.6960582,11.4050769 29.4960833,11.4050769" id="Path" fill="#EB4335"></path>-->
<!--                                                </g>-->
<!--                                            </g>-->
<!--                                        </svg>-->
<!--                                    </a>-->
<!--                                </div>-->



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

  </section>
<!--   -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
<!--  <footer class="footer py-5">-->
<!--    <div class="container">-->
<!--      <div class="row">-->
<!--        <div class="col-lg-8 mb-4 mx-auto text-center">-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">-->
<!--            Company-->
<!--          </a>-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">-->
<!--            About Us-->
<!--          </a>-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">-->
<!--            Team-->
<!--          </a>-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">-->
<!--            Products-->
<!--          </a>-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">-->
<!--            Blog-->
<!--          </a>-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">-->
<!--            Pricing-->
<!--          </a>-->
<!--        </div>-->
<!--        <div class="col-lg-8 mx-auto text-center mb-4 mt-2">-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-4 me-4">-->
<!--            <span class="text-lg fab fa-dribbble"></span>-->
<!--          </a>-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-4 me-4">-->
<!--            <span class="text-lg fab fa-twitter"></span>-->
<!--          </a>-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-4 me-4">-->
<!--            <span class="text-lg fab fa-instagram"></span>-->
<!--          </a>-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-4 me-4">-->
<!--            <span class="text-lg fab fa-pinterest"></span>-->
<!--          </a>-->
<!--          <a href="javascript:" target="_blank" class="text-secondary me-xl-4 me-4">-->
<!--            <span class="text-lg fab fa-github"></span>-->
<!--          </a>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="row">-->
<!--        <div class="col-8 mx-auto text-center mt-1">-->
<!--          <p class="mb-0 text-secondary">-->
<!--            Copyright © <script>-->
<!--              document.write(new Date().getFullYear())-->
<!--            </script> Soft by Creative Tim.-->
<!--          </p>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </footer>-->
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Google button render -->
  <script>
        function onSuccess(googleUser) {
        console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
        }
        function onFailure(error) {
        console.log(error);
        }
        function renderButton() {
        gapi.signin2.render('my-signin2', {
            'scope': 'profile email',
            'width': 240,
            'height': 50,
            'longtitle': true,
            'theme': 'light',
            'onsuccess': onSuccess,
            'onfailure': onFailure
        });
        }
  </script>

  <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
</body>

</html>
