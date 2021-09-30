<?php

// Only show breadcrumbs when not on default page
if (isset($certname)) {
    $this->Breadcrumbs->add([
        ['title' => 'Individual Certname Details', 'url' => ['controller' => 'Facts', 'action' => 'certname-facts']],
        ['title' => $certname, 'url' => ['controller' => 'Facts', 'action' => 'certname-facts', '?' => ['certname' => $certname]]]
    ]);
}

// If a fact value is set, then update the page title
if (isset($certname)) {
    $this->assign('title', $certname . ' Details');
} else {
    $this->assign('title', 'Individual Certname Details');
}

echo $this->Html->script('highlight.min.js');
echo $this->Html->css('default')

?>
<div class="row">
    <div class="col-12">
        <?php
        echo $this->Breadcrumbs->render(
            ['class' => 'breadcrumb'],
            ['separator' => '<i id="breadcrumb-divider" class="fa fa-angle-right"> </i>']
        );
        ?>
        <div class="card mb-4">
            <div class="card-header pb-0">
                <?php
                // Determine what header to show
                if (isset($certname)) {
                    echo "
                        <div class='alert alert-primary alert-dismissible fade show' role='alert'>
                            <span class='text-white font-weight-bold'>The below is <u>live</u> data, pulled from the server just now.</span>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>";
                    echo "<h5><em><b>'$certname'</b></em> Details</h5>";
                } else {
                    echo '<h5>Individual Certname Details</h5>';
                } ?>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body">
                            <?php
                                // Check if results are set, and display default message if not
                                if (!isset($results)) {
                                    echo 'Welcome to the Individual Certname Details page. Please enter the certname you would like to see details for:';
                                } else {
                                    // Check if the results array is empty (i.e. certname is not real, or the PuppetDB has an error)
                                    if (empty($results)) {
                                        echo 'Unknown cert name, or no details returned from the server! Please check your spelling and try again';
                                    } else {
                                        echo '<div class="input-group px-4 pb-3">
                                              <input type="search" id="certname_details_search" class="form-control" placeholder="Type here to search!">
                                          </div>';
                                        echo '
                                         <div class="row p-4">
                                            <div class="col">
                                                <!-- Begin Accordion -->
                                                <div class="accordion" id="factsAccordion">
                                                    <div class="row">
                                                        <div class="col" id="accordionColOne">';
                                        foreach ($results as $result) {
                                            echo '
                                            <div class="card mb-3">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="' . $result['name'] . 'Heading">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#' . $result['name'] . 'Collapse" aria-expanded="true"
                                                                aria-controls="' . $result['name'] . 'Collapse">
                                                            <strong>' . $result['name'] . '</strong>
                                                            <i class="fa text-xs pt-1 position-absolute end-0 me-3"></i>
                                                        </button>
                                                    </h2>
                                                    <div id="'. $result['name'] . 'Collapse" class="accordion-collapse collapse"
                                                         aria-labelledby="'. $result['name'] . 'Heading">
                                                        <div id="accordion-divider" class="accordion-divider"></div>
                                                        <div class="accordion-body">
                                                            <pre class="code language-json">' .
                                                                json_encode($result['value'], JSON_PRETTY_PRINT) .
                                                            '</pre>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                        }
                                    }
                            } ?>
                        <hr />
                            <div class="form-group">
                                <?php
                                // Create an HTML form for selecting the certname
                                echo $this->Form->create(null, ['url' => ['action' => 'certname-facts']]);
                                echo '<div class="row align-items-center"><div class="col-md-auto">';
                                echo $this->Form->input(
                                    'certname',
                                    [
                                        'class' => 'form-control',
                                        'default' => (isset($certname)) ? $certname : ''
                                    ]
                                );
                                echo '</div><div class="col-md-auto mt-2 mt-md-0">';
                                echo $this->Form->button('Go to cert details!', ['type' => 'submit', 'class' => 'btn btn-primary mb-0 w-100']);
                                echo $this->Form->end();
                                echo '</div>';
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Search functionality for accordion
        $(document).ready(function() {
            $('#certname_details_search').on('change keyup paste click', function () {
                var filter = $(this).val().toLowerCase();
                $("#factsAccordion [data-bs-toggle]").each(function () {
                    if ($(this).text().toLowerCase().trim().indexOf(filter) < 0) {
                        $(this).closest(".card").hide();

                    } else {
                        $(this).closest(".card").show()
                    }
                });
            });

            // Text highlighter without needing to use <pre><code>
            document.querySelectorAll('pre.code').forEach(el => {
                hljs.highlightElement(el);
            });
        })
    </script>
</div>
