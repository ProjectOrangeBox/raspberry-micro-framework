<!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19.-->
<form id="contactForm" action="/" method="post" name="sentMessage" novalidate="novalidate">
	<div class="control-group">
		<div class="form-group floating-label-form-group controls mb-0 pb-2">
			<label>Name</label>
			<input class="form-control" id="name" name="name" type="text" placeholder="Name" required="required" data-validation-required-message="Please enter your name." value="" />
			<p class="help-block text-danger"></p>
		</div>
	</div>
	<div class="control-group">
		<div class="form-group floating-label-form-group controls mb-0 pb-2">
			<label>Email Address</label>
			<input class="form-control" id="email" name="email" type="email" placeholder="Email Address" required="required" data-validation-required-message="Please enter your email address." value="" />
			<p class="help-block text-danger"></p>
		</div>
	</div>
	<div class="control-group">
		<div class="form-group floating-label-form-group controls mb-0 pb-2">
			<label>Phone Number</label>
			<input class="form-control" id="phone" name="phone" type="tel" placeholder="Phone Number" required="required" data-validation-required-message="Please enter your phone number." value="" />
			<p class="help-block text-danger"></p>
		</div>
	</div>
	<div class="control-group">
		<div class="form-group floating-label-form-group controls mb-0 pb-2">
			<label>Message</label>
			<textarea class="form-control" id="message" name="message" rows="5" placeholder="Message" required="required" data-validation-required-message="Please enter a message."></textarea>
			<p class="help-block text-danger"></p>
		</div>
	</div>
	<br />
	<div id="success"></div>
	<div class="form-group"><button class="btn btn-primary btn-xl" id="sendMessageButton" type="submit">Send</button></div>
</form>