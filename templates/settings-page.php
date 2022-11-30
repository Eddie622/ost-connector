<h2>OST Connector Settings</h2>
<form action="options.php" class="ost-form" method="post">
    <?php 
        settings_fields( 'OST_Connector_settings' );
        do_settings_sections( 'OST_Connector' );
        submit_button(); 
    ?>
</form>