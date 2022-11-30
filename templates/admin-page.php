<?php
    // var_dump($errors);
?>

<div class="wrap">
	<h2>Helpdesk</h2>
    <form action="" class="ost-form" method="POST" enctype="multipart/form-data">
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
            <label for="attachments">Attachments:</label>
            <input type="file" multiple name="attachments">
        <?php else: print '<p class="attention">One or more fields have an error. Please check and try again.</p>'; ?>
            <label for="name">Name<span class="attention">*</span></label>
            <input type="text" name="name" <?php if(in_array('name', $errors)): ?>class="error"<?php endif ?>>
            <label for="email">Email<span class="attention">*</span></label>
            <input type="email" name="email" <?php if(in_array('email', $errors)): ?>class="error"<?php endif ?>>
            <label for="subject">Subject<span class="attention">*</span></label>
            <input type="text" name="subject" <?php if(in_array('subject', $errors)): ?>class="error"<?php endif ?>>
            <label for="message">Message<span class="attention">*</span></label>
            <textarea name="message" <?php if(in_array('message', $errors)): ?>class="error"<?php endif ?>></textarea>
            <label for="attachments">Attachments:</label>
            <input type="file" multiple name="attachments">
        <?php endif; ?>
        <?php submit_button('Submit'); ?>
    </form>
    <?php if(isset($success) && $success): ?>
        <p>Thank you for your submission. Your ticket has successfully been submitted</p>
    <?php elseif(isset($success) && !$success): ?>
        <p>An error has occured when submitting your ticket. Please contact the system administrator</p>
    <?php endif; ?>
</div>