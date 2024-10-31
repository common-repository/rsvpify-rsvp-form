<?php

/**
 * Provide a admin area view for the plugin.
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.rsvpify.com
 * @since      1.1.0
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class = "body">
	<div class = "row">
		<div class = "col-md-1"></div>
		<img src = '<?php $str=  WP_PLUGIN_URL . '/rsvpify-rsvp-form/images/icon.png';
		echo $str;?>' class = "col-xs-2">	
	</div>
	<div class = "row">
		<div class = "col-md-8">
		</div>
		<div class = "col-md-4">
			<a href = "http://www.rsvpify.com/" target="_blank">Don't have an RSVPify event yet?</a>
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-1"></div>
		<div class = 'col-md-10'>
			<table class="table table-bordered" id = "myTable">
				<tr>
					<th>Event Name</th>
					<th>RSVPify Subdomain</th> 
					<th>Embed Shortcode</th>
					<th>Delete</th>
				</tr>

				<?php
				global $wpdb;
				$result = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "embed_rsvpify_plugin");
				foreach ($result as $key => $value) {
					echo '<tr>';
					echo '<td>';
					echo stripslashes($value->event_name);
					echo '</td>';
					echo '<td>';
					echo stripslashes($value->subdomain);
					echo '</td>';
					echo '<td>';
					echo '[' . stripslashes($value->subdomain) . ']';
					echo '</td>';
					echo '<td>';
					echo "<a href='#'>
					<span class='glyphicon glyphicon-remove' id = '{$value->subdomain}'></span>
				</a>";
				echo '</td>';
				echo '</tr>';

				if ($result == null) {
					echo "			
					<tr>
						<td colspan='3'><center>You haven't added any events yet.</center></td>
					</tr>";
				}
			}
			?>

		</table>
	</div>
	<div class = "col-md-1"></div>
</div>

<div class = "row">
	<div class = "col-md-1"></div>
	<div class = "col-md-1">
		<button class="btn sample btn-sample" id = "submit_button" data-toggle="modal" 
		data-target="#basicModal">Add Event</button>
	</div>
</div>

<div class="modal fade" id = "myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add RSVPify Event</h4>
			</div>
			<div class="modal-body">
				<form method = "post">
					<div class="form-group" id = "event_group">
						<label for="event_id">Event ID</label>
						<input type="text" class="form-control"
						id="event_id" name = "event_id" placeholder="Enter your event ID"/>
						<label class="control-label" id = "event_error_label" for = "event_id" style="display:none">Please enter an integer value</label>
					</div>
					<div class="form-group">
						<input type="checkbox" id="toggle-https" class="form-control" name="toggle-https" checked>
					</div>
					<div class="modal-footer">
						<font class = "pull-left" color="#C6C6C6">e.g. https://app.rsvpify.com/event/<font color = "gray"><b>51232</b></font></font>
						<button type="button" class="btn sample btn-sample-cancel" data-dismiss="modal">Cancel</button>
						<button type="button" id = "add_event_button" class="btn sample btn-sample">Add Event</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>

<div class="modal fade" id = "cancelModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Remove Event</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<p>
						Are you sure you want to remove this event? This action won't affect your event outside of this WordPress instance.
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn sample btn-sample-cancel" data-dismiss="modal">Cancel</button>
					<button type="button" id = "delete_event_button" class="btn sample btn-sample">Continue</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>
</div>
