<?php

?>

<footer class="footer py-3">
<div class="container-fluid">
    <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6 mb-lg-0 mb-4">
            <div class="copyright text-center text-sm text-muted text-lg-start">
        ©   <script>
                document.write(new Date().getFullYear())
            </script>,
            Created by Marble Benchtop | Data by Schoolbox
            </div>
        </div>
        <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                    <?= $this->Html->link(
                        'All Datasets',
                        ['controller' => 'Historical-Facts', 'action' => 'index'], array('class' => 'nav-link text-muted')
                    ) ?>
                </li>
                <li class="nav-item">
                    <?= $this->Html->link(
                        'Latest Dataset',
                        ['controller' => 'Historical-Facts', 'action' => 'newest-data'], array('class' => 'nav-link text-muted')
                    ) ?>
                </li>
            </ul>
        </div>
    </div>
</div>
</footer>
