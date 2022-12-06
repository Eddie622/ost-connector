<div class="wrap">
	<h2><?php echo esc_html_e($options['name']); ?> Helpdesk</h2>
    <form action="" class="ost-form" method="POST" enctype="multipart/form-data">
        <!-- Notification Prior to attachment implementation. Please DELETE when functionality is created -->
        <p>
            File attachments are currently unavailable within this form. If you wish to include attachments, please visit 
            <a href="<?php print('https://'.esc_html($options['url'].'/open.php')); ?>" target="_blank"><?php echo esc_html_e($options['url']); ?></a> 
            and submit a ticket.
        </p>
        <!-- End Notification -->
        <h3>Submit A Ticket</h3>
        <?php if(empty($errors)): ?>
            <label for="name">Name<span class="attention">*</span></label>
            <input type="text" name="name">
            <label for="email">Email<span class="attention">*</span></label>
            <input type="email" name="email">
            <label for="subject">Subject<span class="attention">*</span></label>
            <input type="text" name="subject">
            <label for="message">Message<span class="attention">*</span></label>
            <textarea name="message"></textarea>
            <!--<label for="attachments">Attachments:</label>-->
            <!--<input type="file" multiple name="attachments">-->
        <?php else: print '<p class="attention">One or more fields have an error. Please check and try again.</p>'; ?>
            <label for="name">Name<span class="attention">*</span></label>
            <input type="text" name="name" <?php if(in_array('name', $errors)): ?>class="error"<?php endif; ?> value="<?php empty($_POST['name'])?:print($_POST['name']); ?>">
            <label for="email">Email<span class="attention">*</span></label>
            <input type="email" name="email" <?php if(in_array('email', $errors)): ?>class="error"<?php endif; ?> value="<?php empty($_POST['email'])?:print($_POST['email']); ?>">
            <label for="subject">Subject<span class="attention">*</span></label>
            <input type="text" name="subject" <?php if(in_array('subject', $errors)): ?>class="error"<?php endif; ?> value="<?php empty($_POST['subject'])?:print($_POST['subject']); ?>">
            <label for="message">Message<span class="attention">*</span></label>
            <textarea name="message" <?php if(in_array('message', $errors)): ?>class="error"<?php endif; ?>><?php empty($_POST['message'])?:print($_POST['message']); ?></textarea>
            <!--<label for="attachments[]">Attachments:</label>-->
            <!--<input type="file" name="attachments[]" multiple>-->
        <?php endif; ?>
        <?php submit_button('Submit'); ?>
    </form>
    <?php if(isset($success) && $success): ?>
        <p>Thank you for your submission. Your ticket has successfully been submitted</p>
    <?php elseif(isset($success) && !$success): ?>
        <p>An error has occured when submitting your ticket. Please contact the system administrator or submit a ticket at <?php echo $options['url'] ?></p>
    <?php endif; ?>
</div>