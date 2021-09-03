<?php
    // $this->disableAutoLayout();
?>

<!DOCTYPE html>
<html lang="en">

<body class="g-sidenav-show bg-gray-100">
  <section class="min-vh-100">
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
                            <div class="card-header text-center">
                                <?= $this->Html->image('../favicon.ico', ['class' => 'img-fluid']); ?>
<!--                                <h5>Login with Google</h5>-->
                            </div>
                            <div class="row px-xl-5 px-sm-4 px-3">
                                <?=
                                    $this->Flash->render();
                                ?>
                                <h3 class="card-header text-center"> Login with Google </h3>
                                <!-- ATTEMPTED CONVERSION OF TEMPLATE TO PHP -->
                                <?php
                                echo $this->Form->postLink(
                                    $this->Html->Image('google_logo.svg'),
                                    [
                                        'prefix' => false,
                                        'plugin' => 'ADmad/SocialAuth',
                                        'controller' => 'Auth',
                                        'action' => 'login',
                                        'provider' => 'google',
                                        '?' => ['redirect' => $this->request->getQuery('redirect')]
                                    ],
                                    [
                                        'class' => 'nav-link active btn btn-outline-light w-100 bg-white ml-3',
                                        'escape' => false
                                    ]
                                );
                                ?>
                            </div>
                            <div class="pb-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>

  </section>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
</body>

</html>
