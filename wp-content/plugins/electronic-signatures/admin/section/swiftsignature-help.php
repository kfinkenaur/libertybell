<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function ssign_help_cb() {

    wp_enqueue_script('ss-copy-script', plugins_url('../js/swiftsignature-copy-script.js', __FILE__), array('jquery'), '', true);
    ?>
    <div class = "wrap  ss-help">
        <h2>Welcome to Swift Signature</h2><hr/>
        <?php
        if (isset($_GET['update']) && !empty($_GET['update']) && $_GET['update'] == 1) {
            ?>
            <div id="message" class="notice notice-success is-dismissible below-h2">
                <p>Page added successfully.<?php echo $msg; ?> </a></p>
                <button type="button" class="notice-dismiss">
                    <span class="screen-reader-text">Dismiss this notice.</span>
                </button>
            </div>
            <?php
        }
        ?>
        <div class="inner_content">
            <h3>5 Minute Setup:</h3>
            <ol>
                <li><p><?php _e('Copy everything in the white area below*', 'swift-signature'); ?></p>
                    <div id="msg"></div>
                    <div class="copy-btn"><button id="btn-copy" type="button" class="button-orange">COPY</button></div>
                    <div class="pre-code" id="copy-content"><xmp>[swiftsign swift_form_id="SWIFTFORMIDHERE"]
    I, [swift_email name="email" required], and YOURCOMPANYHERE agree to the following awesome text:
    <ol>
        <li>Penguins are cute</li>
        <li>Dolphins are fun</li>
        <li>Great whites are not cute.</li>
        <li>Replace this area with whatever you want agreement on.</li>
    </ol>
    [swiftsignature]
    I hereby agree to the above.

    Addendum A:
    [swift_initials] I also warrant I am not a great white shark.

    [swift_textbox name="user_name"][swift_email name="user_email"]

    [swift_button]

[/swiftsign]</xmp>
                    </div>
                </li>
                <li><p><?php _e('Make a new page called esign, and paste all of this into it and hit publish.<br/>Tip: Click “Text” in Wordpress and it’ll format better when you paste. Also, note the orange email field is required somewhere anywhere in the form between the main tags.', 'swift-signature'); ?></p></li>
                <li><p><?php _e('Next, setup your <a href="http://swiftcloud.io/#s?site_url=http://swiftsignature.com&utm_source=WordpressPlugin&utm_medium=WPHelpTab&utm_campaign=WPPluginHelpTab&pr=89&button=CCTAB" target="_blank">Free or Paid SwiftCloud Account</a>.', 'swift-signature'); ?></p>
                    <ol>
                        <li><p><?php _e('Once you have and are logged in, you need to create a web-form, at <a href="http://swiftcloud.io/form/create-form?site_url=http://swiftsignature.com&utm_source=WordpressPlugin&utm_medium=WPHelpTab&utm_campaign=WPPluginHelpTab&pr=89&button=CCTAB" target="_blank">http://swiftcloud.io/form/create-form</a> --- just give it a name of “Website e-Signature top left, and click save - it doesn’t matter what fields you have in it for now. Take note of the number though, you’ll need it. Above at the top, replace the number with your form ID number (as highlighted in yellow). In this example, it’s 419 so you’d replace 123456789 with 419', 'swift-signature'); ?></p>
                            <img src="<?php echo plugins_url('../images/ss-help-1.png', __FILE__); ?>">
                        </li>
                        <li><p><?php _e('b.	Ensure your after-signature URL / behavior is correct. For now until it’s working, keep it simple and on the right side, leave at the default “Thank you confirmation URL”, and enter YOURDOMAINHERE.com/thanks (then later go make a page with “/thanks” as the slug / URL)', 'swift-signature'); ?></p>
                            <img src="<?php echo plugins_url('../images/ss-help-2.png', __FILE__); ?>">
                        </li>
                    </ol>
                </li>
                <li><p><?php _e('That\'s it! By now the most basic of signature should be working, and when you run a test, after 5-10 minutes (depending on your speed of email etc.) you should get notified when documents are signed. In addition, the "e-Signatures" list on Swift Signature will show sessions, along with a link to the resulting signed page.', 'swift-signature'); ?></p></li>
            </ol>
            <p><?php _e('Thanks and welcome!', 'swift-signature'); ?></p>
            <p><?php _e('Want more options? See <a href="http://swiftsignature.com/support?site_url=http://swiftsignature.com&utm_source=WordpressPlugin&utm_medium=WPHelpTab&utm_campaign=WPPluginHelpTab&pr=89&button=CCTAB" target="_blank">http://SwiftSignature.com/support</a> for more advanced options including pre-filling variables, multiple documents in a single envelope, auditing, payment flow options and others.', 'swift-signature'); ?></p>
            <div class="yellow-bg">
                <?php _e('A personal note: This was built out of necessity - we’re not some huge company. I (Roger, the lead developer) encourage you to drop us a note at  <a href="https://SwiftCloud.AI/support/contact?site_url=http://swiftsignature.com&utm_source=WordpressPlugin&utm_medium=WPHelpTab&utm_campaign=WPPluginHelpTab&pr=89&button=CCTAB" target="_blank">https://SwiftCloud.AI/support</a> with any requests or ideas on how to make it better. ', 'swift-signature'); ?>
            </div>
        </div>
    </div>
    <?php
}
?>
