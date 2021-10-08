<?php
    // $this->disableAutoLayout();
    $this->assign('title', 'Login');
?>

<!DOCTYPE html>
<html lang="en">

<body class="g-sidenav-show bg-gray-100">
  <section class="min-vh-100">
    <div class="page-header align-items-start min-vh-95 pt-5 m-3 border-radius-lg animation-area">
      <span class="mask bg-gradient-dark opacity-2"></span>
      <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 text-center mx-auto">
                <h1 class="text-white mb-3 mt-5">Schoolbox Server Health</h1>
            </div>
            <div class="container img-fluid">
                <div class="">
                    <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                        <div class="card z-index-0">
                            <div class="card-header text-center card-logo">
                                <?= $this->Html->image('../favicon.ico', ['class' => 'img-fluid']); ?>
                            </div>
                            <div class="row px-5 mx-3">
                                <h3 class="card-header text-center pt-0 pb-3"> Login with Google </h3>
                                <?php
                                $redirectUrl = '';
                                foreach($this->request->getQueryParams() as $param => $key) {
                                    $redirectUrl .= '&' . $param . '=' .$key;
                                }
                                $redirectUrl = str_replace('&redirect=', '', $redirectUrl);
                                echo $this->Form->postLink(
                                    $this->Html->Image('google_logo.svg'),
                                    [
                                        'prefix' => false,
                                        'plugin' => 'ADmad/SocialAuth',
                                        'controller' => 'Auth',
                                        'action' => 'login',
                                        'provider' => 'google',
                                        '?' => ['redirect' => $redirectUrl]
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
                        <br>
                        <?=
                        $this->Flash->render();
                        ?>
                    </div>
                </div>
            </div>
        </div>
      </div>
        <ul class="box-area">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
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
