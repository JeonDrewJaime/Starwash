<?php
include('db_connect.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';  // Include PHPMailer's autoload file

if ($_POST) {
    $firstName = $_POST['name'];
    $lastName = $_POST['lname'];
    $email = $_POST['email'];
    $message = $_POST['msg'];
    $messageOption = $_POST['option'];

    // Setup PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'starwash099@gmail.com';  // SMTP username
        $mail->Password = 'rxqxgchxsmhkzqao';      // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your-email@example.com', 'Star Wash Laundry Shop');
        $mail->addAddress($email, $firstName . ' ' . $lastName);  // Add recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Laundry Update';
        
        // Set the message based on the selected option
        $messageBody = '';
        if ($messageOption == 1) {
            $messageBody = "We'd like to inform you that your laundry is ready to claim.";
        } elseif ($messageOption == 2) {
            $messageBody = "We'd like to inform you that your laundry has an unnecessary damage. We apologize for the inconvenience.";
        } elseif ($messageOption == 3) {
            $messageBody = "We'd like to inform you that you've forgotten something.";
        } else {
            $messageBody = "We'd like to inform you that your laundry is already finished.";
        }

        // Add the custom message
        $messageBody .= "<br><br>" . nl2br($message);  // Add the message provided in the form

        $mail->Body = $messageBody;

        // Send the email
        if ($mail->send()) {
            echo '<p>Message Sent!</p>';
        } else {
            echo '<p>Error sending message: ' . $mail->ErrorInfo . '</p>';
        }
    } catch (Exception $e) {
        echo "<p>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</p>";
    }
}
?>
<br>
<sdiv class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<!-- table for contacts -->
						<div class="card-header">
							<h4><b>Contacts</b></h4>
						</div>
						<div class="col-md-13">
							<div class="card">
								<div class="card-body">
									<table id="table_id" class="display">
										<thead>
											<tr>
												<th class="text-center">#</th>
												<th class="text-center">Date</th>
												<th class="text-center">First Name</th>
												<th class="text-center">Last Name</th>
												<th class="text-center">Contact No.</th>
												<th class="text-center">Email</th>
												<th class="text-center">Status</th>
												<th class="text-center">Remarks</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$i = 1;
											$contacts = $conn->query("SELECT * FROM laundry_list order by id asc");
											while($row=$contacts->fetch_assoc()):
											?>
											<tr>
												<td class="text-center"><?php echo $i++?></td>
												<td class=""><?php echo date("M d, Y",strtotime($row['date_created'])) ?></td>
												<td class="text-center"><?php echo $row['first_name']?></td>
												<td class="text-center"><?php echo $row['last_name']?></td>
												<td class="text-center"><?php echo $row['contact']?></td>
												<td class="text-center"><?php echo $row['email']?></td>
												<?php if($row['status'] == 0): ?>
													<td class="text-center"><span class="badge badge-secondary">Pending</span></td>
												<?php elseif($row['status'] == 1): ?>
													<td class="text-center"><span class="badge badge-primary">Processing</span></td>
												<?php elseif($row['status'] == 2): ?>
													<td class="text-center"><span class="badge badge-info">Ready to be Claim</span></td>
												<?php elseif($row['status'] == 3): ?>
													<td class="text-center"><span class="badge badge-success">Claimed</span></td>
												<?php endif; ?>
												<td class="text-center"><?php echo $row['remarks']?></td>
												<td class="text-center"><button type="submit" class="btn btn-info btn-sm btn-block btn-use">Use</button></td>
											</tr>
											<?php endwhile;?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- FORM Panel -->
			<div class="col-md-4">
				<form method="post">
					<div class="card">
						<div class="card-header">
							<h4><b>New Message</b></h4>
						</div>
						<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">First Name: </label>
								<input type="text" maxlength="25" class="form-control" id="firstname" name="name" required>
							</div>
							<div class="form-group">
								<label class="control-label">Last Name: </label>
								<input type="text" maxlength="25" class="form-control" id="lastname" name="lname" required>
							</div>
							<div class="form-group">
								<label class="control-label">Email: </label>
								<input type="email" maxlength="100" class="form-control" id="contactemail" name="email" required>
							</div>

							<!-- Dropdown list for message option -->
							<div class="form-group">
								<label role="button" class="control-label">Message Option: </label>
								<select class="form-control" name="option" id="msgoption">
									<option value="default" selected disabled>Select Message...</option>
									<option value="1">Your laundry is ready to claim.</option>
									<option value="2">Your laundry have an unnecessary damage</option>
									<option value="3">You have forgotten something</option>
									<option value="4">Your laundry is finished.</option>
								</select>
								<br>
								<br> 
								<textarea class="form-control" name="msg" id="textArea" rows="4" cols="50" placeholder="Message here." onkeyup="countChar(this)" onchange="countChar(this)" required> </textarea>
							</div>
							<p class="text-lect" id="charNum">200</p>
						</div>
						
						<div class="card-footer">
							<div class="row">
								<div class="col-md-12">
									<input type="submit" value="Send Message" class="btn btn-primary btn-lg btn-block">
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<!-- FORM Panel -->
		</div>
	</div>	
</div>

<script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		function countChar(val){
			var len = val.value.length;
			if(len >= 200)
				val.value = val.value.substring(0,200);
			else
            	$('#charNum').text(200 - len);
    	}
        $('#table_id').DataTable();
		$(".btn-use").on('click', function(){
			$tr = $(this).closest('tr');
			var data = $tr.children("td").map(function () {
				return $(this).text();
			}).get();
			$(".form-group #firstname").val(data[2])
			$(".form-group #lastname").val(data[3])
			$(".form-group #contactemail").val(data[5])
		})
		$("#msgoption").on('change', function(e){
			e.preventDefault();
			var selectedVal = $("#msgoption option:selected").val();
			var strApp = "Good Day! This message is from Star Wash Laundry Shop,\n";
			var strvalue = '';

			if(selectedVal == 1)
				strvalue = "We'd like to inform you that your laundry is ready to claim."
			else if(selectedVal == 2)
				strvalue = "We'd like to inform you that your laundry have an unnecessary damage. We apologize for the inconvenience."
			else if(selectedVal == 3)
				strvalue = "We'd like to inform you that you've forgotten something."
			else
				strvalue = "We'd like to inform you that your laundry is already finished."

			$("#textArea").val(strApp + strvalue)
		})
	});
</script>
</body>
</html>
