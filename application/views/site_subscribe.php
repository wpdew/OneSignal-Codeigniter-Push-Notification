<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Push notificator</title>

	<style type="text/css">

	::selection { background-color: #f07746; color: #fff; }
	::-moz-selection { background-color: #f07746; color: #fff; }

	body {
		background-color: #fff;
		margin: 40px auto;
		font: 16px/24px normal "Helvetica Neue",Helvetica,Arial,sans-serif;
		color: #808080;
	}

	a {
		color: #dd4814;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
	}

	a:hover {
	   color: #97310e;
	}

	h1 {
		color: #fff;
		background-color: #dd4814;
		border-bottom: 1px solid #d0d0d0;
		font-size: 22px;
		font-weight: bold;
		margin: 0 0 14px 0;
		padding: 5px 10px;
		line-height: 40px;
	}

	h1 img {
		display: block;
	}

	h2 {
		color:#404040;
		margin:0;
		padding:0 0 10px 0;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 13px;
		background-color: #f5f5f5;
		border: 1px solid #e3e3e3;
		border-radius: 4px;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
		min-height: 96px;
	}

	p {
		 margin: 0 0 10px;
		 padding:0;
	}

	p.footer {
		text-align: right;
		font-size: 12px;
		border-top: 1px solid #d0d0d0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
		background:#8ba8af;
		color:#fff;
	}

	#container {
		margin-top: 10px;
		border: 1px solid #d0d0d0;
		box-shadow: 0 0 8px #d0d0d0;
		border-radius: 4px;
	}
	</style>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

<div class="container" id="container">
	<div class="row">
		<div class="col-md-12">

<div class="starter-template">
                <h1 style="    font-size: 24px;font-weight: 700;color: #fff;">OneSignal  Subscription</h1>
                <p class="lead">Admin panel page</p>
            </div>

            <div class="contact-form">

                <p class="notice error"><?= $this->session->flashdata('error_msg') ?></p><br/>

                <form id="ServiceRequest" action="<?php echo base_url('push/admin/send_message'); ?>" method='post'>
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
                        <input type="text" name="url" class="form-control" placeholder="Add Your url" value="<?php echo URLDEFOLTSITE;?>" >
                    </div>
					
					<div class="form-group">
                        <label class="control-label">Your img:</label>
                        <input type="text" name="img" class="form-control" placeholder="Add Your img" value="<?php echo URLDEFOLTIMG;?>" >
                    </div>
					
					
					
					<div class="form-group">
                        <input type="hidden" name="user_id" class="form-control" readonly value="4444" >
                    </div>
                    <div id='submit_button'>
                        <input class="btn btn-success" type="submit" name="submit" value="Send data"/>
                        <input style="width: 100px;" onclick="location.href='<?php echo CMS_URI;?>/admin/logout';" class="btn btn-info pull-right" value="LOGOUT"/>
                    </div>
                </form>
                <br />
            </div>
		</div>
	</div>					
</div>
			
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
        <script>
            var OneSignal = window.OneSignal || [];
            OneSignal.push(["init", {
                appId: "<?php echo APPID; ?>",
                subdomainName: 'gemelli',
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
        </body>
</html>