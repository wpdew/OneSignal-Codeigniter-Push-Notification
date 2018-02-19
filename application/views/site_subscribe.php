
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="container">
	<div class="row">
		<div class="col-md-12">

<div class="starter-template">
                <h1>OneSignal  Subscription</h1>
                <p class="lead">User Subscribe Page</p>
            </div>

            <div class="contact-form">

                <p class="notice error"><?= $this->session->flashdata('error_msg') ?></p><br/>

                <form id="ServiceRequest" action="<?php echo base_url('quotes/send_message'); ?>" method='post'>
					<div class="form-group">
                        <label class="control-label">Message Title:</label>
                        <input type="text" name="headings" class="form-control" placeholder="Add Your Title" value="" >
                    </div>
					
                    <div class="form-group">
                        <label class="control-label">Message Body:</label>
                        <input type="text" name="message" class="form-control" placeholder="Add Your Message" value="" >
                    </div>
                    
					<div class="form-group">
                        <label class="control-label">Your url:</label>
                        <input type="text" name="url" class="form-control" placeholder="Add Your url" value="" >
                    </div>
					
					<div class="form-group">
                        <label class="control-label">Your img:</label>
                        <input type="text" name="img" class="form-control" placeholder="Add Your img" value="<?php echo URLDEFOLTIMG;?>" >
                    </div>
					
					
					
					<div class="form-group">
                        <label class="control-label">Message Body:</label>
                        <input type="hidden" name="user_id" class="form-control" readonly value="4444" >
                    </div>
                    <div id='submit_button'>
                        <input class="btn btn-success" type="submit" name="submit" value="Send data"/>
                    </div>
                </form>
            </div>
		</div>
	</div>					
</div>
			
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
        <script>
            var OneSignal = window.OneSignal || [];
            OneSignal.push(["init", {
                appId: "<?php echo APPID; ?>",
                subdomainName: 'push',
                autoRegister: true,
                promptOptions: {
                    /* These prompt options values configure both the HTTP prompt and the HTTP popup. */
                    /* actionMessage limited to 90 characters */
                    actionMessage: "<?php echo ACTIONMESSAGE;?>",
                    /* acceptButtonText limited to 15 characters */
                    acceptButtonText: "<?php echo ACCEPTBUTTONTEXT;?>",
                    /* cancelButtonText limited to 15 characters */
                    cancelButtonText: "<?php echo CANCELBUTTONTEXT;?>"
                }
            }]);
        </script>
        <script>
            function subscribe() {
                // OneSignal.push(["registerForPushNotifications"]);
                OneSignal.push(["registerForPushNotifications"]);
                event.preventDefault();
            }
            function unsubscribe(){
                OneSignal.setSubscription(true);
            }

            var OneSignal = OneSignal || [];
            OneSignal.push(function() {
                /* These examples are all valid */
                // Occurs when the user's subscription changes to a new value.
                OneSignal.on('subscriptionChange', function (isSubscribed) {
                    console.log("The user's subscription state is now:", isSubscribed);
                    OneSignal.sendTag("user_id","4444", function(tagsSent)
                    {
                        // Callback called when tags have finished sending
                        console.log("Tags have finished sending!");
                    });
                });

                var isPushSupported = OneSignal.isPushNotificationsSupported();
                if (isPushSupported)
                {
                    // Push notifications are supported
                    OneSignal.isPushNotificationsEnabled().then(function(isEnabled)
                    {
                        if (isEnabled)
                        {
                            console.log("Push notifications are enabled!");

                        } else {
                            OneSignal.showHttpPrompt();
                            console.log("Push notifications are not enabled yet.");
                        }
                    });

                } else {
                    console.log("Push notifications are not supported.");
                }
            });


        </script>