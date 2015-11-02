<div class="wrap">

    <h2>Forms</h2>

    <form method="post">
        <?php $table->display(); ?>
    </form>

    <?php

        if( isset( $_GET['debug' ] ) ){

            $forms = Ninja_Forms()->form()->get_forms();

            foreach( $forms as $form ){

                echo "<pre>";
                var_dump( $form->get_settings() );
                echo "</pre>";
            }
        }

    ?>

</div>