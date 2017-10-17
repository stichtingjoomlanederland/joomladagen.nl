<?php
/**
 * @version    SVN: <svn_id>
 * @package    JTicketing
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2016 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */

$emails_config = array('message_body' => "<!DOCTYPE html>
<html xmlns=\"http://www.w3.org/1999/xhtml\">
	<head>
		<!--[if gte mso 9]>
		<xml>
			<o:OfficeDocumentSettings>
				<o:AllowPNG/>
				<o:PixelsPerInch>96</o:PixelsPerInch>
			</o:OfficeDocumentSettings>
		</xml>
		<![endif]-->
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
		<meta name=\"viewport\" content=\"width=device-width\">
		<meta http-equiv=\"X-UA-Compatible\" content=\"IE=9; IE=8; IE=7; IE=EDGE\">
		<title>Template Base</title>
		<!--[if !mso]><!- - -->
		<link href=\"https://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\">
		<!--<![endif]-->
	</head>
	<body style=\"width: 100% !important;min-width: 100%;
	-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100% !important;
	margin: 0;padding: 0;background-color: #FFFFFF\">
	<style id=\"media-query\">
	/* Client-specific Styles & Reset */ #outlook a { padding: 0; } /* .ExternalClass applies to Outlook.com (the artist formerly known as Hotmail) */
	 .ExternalClass { width: 100%; } .ExternalClass, .ExternalClass p,
	  .ExternalClass span, .ExternalClass font, .ExternalClass td,
	   .ExternalClass div { line-height: 100%; }
	  #backgroundTable { margin: 0; padding: 0; width: 100% !important; line-height: 100% !important; }
	   /* Buttons */ .button a { display: inline-block; text-decoration: none;
	    -webkit-text-size-adjust: none; text-align: center; } .button a div { text-align: center !important; }
	    /* Outlook First */ body.outlook p { display: inline !important; }
	    /* Media Queries */ @media only screen and (max-width: 500px)
	    { table[class=\"body\"] img { height: auto !important; width: 100% !important; }
	     table[class=\"body\"] img.fullwidth { max-width: 100% !important; }
	      table[class=\"body\"] center { min-width: 0 !important; }
	       table[class=\"body\"] .container { width: 95% !important; }
	       table[class=\"body\"] .row

	       { width: 100% !important; display: block !important; }
	       table[class=\"body\"]
	       .wrapper { display: block !important; padding-right: 0 !important; }
	       table[class=\"body\"] .columns, table[class=\"body\"]
	       .column { table-layout: fixed !important; float: none !important;
	        width: 100% !important; padding-right: 0px !important; padding-left: 0px !important; display: block !important; }
	        table[class=\"body\"] .wrapper.first .columns, table[class=\"body\"] .wrapper.first .column
	         { display: table !important; } table[class=\"body\"] table.columns td, table[class=\"body\"] table.column td,
	         .col { width: 100% !important; }
	          table[class=\"body\"]
	          table.columns td.expander { width: 1px !important; }
	           table[class=\"body\"] .right-text-pad, table[class=\"body\"]
	            .text-pad-right { padding-left: 10px !important; } table[class=\"body\"]
	            .left-text-pad, table[class=\"body\"] .text-pad-left
	            { padding-right: 10px !important; }
	            table[class=\"body\"] .hide-for-small, table[class=\"body\"]
	             .show-for-desktop { display: none !important; }

	             table[class=\"body\"] .show-for-small,
	              table[class=\"body\"] .hide-for-desktop { display: inherit !important; }
	               .mixed-two-up .col { width: 100% !important; } }
	                @media screen and (max-width: 500px) { div[class=\"col\"] { width: 100% !important; } } @media screen and (min-width: 501px)
	                { table[class=\"container\"] { width: 500px !important; } } </style>
	<table class=\"body\" style=\"border-spacing: 0;border-collapse: collapse;
	vertical-align: top;height: 100%;width: 100%;
	table-layout: fixed\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
		<td class=\"center\" style=\"word-break: break-word;border-collapse: collapse !important;
		vertical-align: top;text-align: center;background-color: #FFFFFF\" align=\"center\" valign=\"top\">
		<table style=\"border-spacing: 0;border-collapse: collapse;
		vertical-align: top;background-color: transparent\" cellpadding=\"0\"
		cellspacing=\"0\" align=\"center\" width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
		 <td style=\"word-break: break-word;border-collapse: collapse !important;
		 vertical-align: top\" width=\"100%\"> <table class=\"container\"
		 style=\"border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;
		 margin: 0 auto;text-align: inherit\" cellpadding=\"0\" cellspacing=\"0\"
		  align=\"center\" width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
		<td style=\"word-break: break-word;border-collapse: collapse !important;
		vertical-align: top\" width=\"100%\"> <table class=\"block-grid\"
		style=\"border-spacing: 0;border-collapse: collapse;vertical-align: top;
		width: 100%;max-width: 500px;color: #000000;background-color: transparent\"
		cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" bgcolor=\"transparent\">
	<tbody>
		<tr style=\"vertical-align: top\">
		 <td style=\"word-break: break-word;border-collapse: collapse !important;
		 vertical-align: top;text-align: center;font-size: 0\">
		 <div class=\"col num12\" style=\"display: inline-block;vertical-align: top;
		 width: 100%\"> <table style=\"border-spacing: 0;border-collapse: collapse;
		 vertical-align: top\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\"
		 width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
		<td style=\"word-break: break-word;border-collapse: collapse !important;
		vertical-align: top;background-color: transparent;padding-top: 5px;
		padding-right: 0px;
		padding-bottom: 5px;padding-left: 0px;border-top: 0px solid transparent;border-right: 0px solid transparent;
		border-bottom: 0px solid transparent;
		border-left: 0px solid transparent\">
		 <table style=\"border-spacing: 0;border-collapse: collapse;
		 vertical-align: top\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
	<tbody>
		<tr style=\"vertical-align: top\">
		<td style=\"word-break: break-word;border-collapse: collapse !important;
		vertical-align: top;padding-top: 5px;padding-right: 5px;
		padding-bottom: 5px;padding-left: 5px\">
		<div style=\"color:#555555;line-height:120%;font-family:\'Open Sans\',
		 \'Helvetica Neue\',
		Helvetica, Arial, sans-serif;\"> <div style=\"font-size:12px;
		line-height:14px;color:#555555;
		font-family:\'Open Sans\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;text-align:left;\">
		 <p style=\"margin: 0;font-size: 14px;line-height: 17px\">
		 <span style=\"font-size: 11px; line-height: 13px;\">Your ticket for [EVENT_NAME]</span><br>
		 </p> </div> </div> </td> </tr>
	</tbody>
	</table> </td> </tr> </tbody> </table> </div> </td> </tr>
	</tbody> </table> </td> </tr> </tbody> </table> </td> </tr>
	 </tbody> </table>
	 <table style=\"border-spacing: 0;border-collapse: collapse;
	 vertical-align: top;background-color: transparent\" cellpadding=\"0\"
	 cellspacing=\"0\" align=\"center\" width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
		<td style=\"word-break: break-word;border-collapse: collapse !important;
		vertical-align: top\" width=\"100%\"> <table class=\"container\" style=\"border-spacing: 0;border-collapse: collapse;vertical-align: top;
		max-width: 500px;margin: 0 auto;text-align: inherit\" cellpadding=\"0\"
		cellspacing=\"0\" align=\"center\" width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
		<td style=\"word-break: break-word;border-collapse: collapse !important;
		vertical-align: top\" width=\"100%\">
		 <table class=\"block-grid\" style=\"border-spacing: 0;
		 border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #000000;
		 background-color: transparent\" cellpadding=\"0\" cellspacing=\"0\"
		 width=\"100%\" bgcolor=\"transparent\">
	<tbody>
		<tr style=\"vertical-align: top\">
		<td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top;
		text-align: center;font-size: 0\">
		<div class=\"col num12\" style=\"display: inline-block;vertical-align: top;width: 100%\">
		<table style=\"border-spacing: 0;border-collapse: collapse;
		vertical-align: top\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
		 <td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top;
		 background-color: transparent;padding-top: 5px;
		 padding-right: 0px;padding-bottom: 5px;
		 padding-left: 0px;border-top: 0px solid transparent;
		 border-right: 0px solid transparent;
		 border-bottom: 0px solid transparent;border-left: 0px solid transparent\">
		 <table style=\"border-spacing: 0;border-collapse: collapse;
		 vertical-align: top\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
			<td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top;width: 100%\" align=\"center\">
			<div style=\"font-size:12px\" align=\"center\"> [EVENT_IMAGE] </div>
			</td>
		</tr>
	</tbody>
	</table> <table style=\"border-spacing: 0;border-collapse: collapse;vertical-align: top\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
	<tbody>
		<tr style=\"vertical-align: top\">
		<td style=\"word-break: break-word;border-collapse: collapse !important;
		vertical-align: top;padding-top: 10px;padding-right: 10px;padding-bottom: 10px;padding-left: 10px\">
		 <div style=\"color:#555555;line-height:120%;font-family:\'Open Sans\',
		 \'Helvetica Neue\', Helvetica, Arial, sans-serif;\">
		  <div style=\"font-size:12px;line-height:14px;color:#555555;
		  font-family:\'Open Sans\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;text-align:left;\">
		   <p style=\"margin: 0;font-size: 12px;line-height: 14px\">Hello [NAME],</p>
		   <p style=\"margin: 0;font-size: 12px;line-height: 14px\">Here are&nbsp;your ticket(s) for [EVENT_NAME].&nbsp;</p>
		   <p style=\"margin: 0;font-size: 12px;line-height: 14px\">&nbsp;</p>
		   <p style=\"margin: 0;font-size: 12px;
		   line-height: 14px\">This email itself serves as a ticket. If you wish to save&nbsp;a copy, you can find it attachment to Download.&nbsp;
		   Please present this email at the entrance for verification.</p> </div> </div> </td> </tr>
	</tbody>
	</table> </td> </tr> </tbody> </table>
	</div> <!--[if (gte mso 9)|(IE)]> </td> <![endif]-->
	<!--[if (gte mso 9)|(IE)]></td> </tr> </table>
	<![endif]--> </td> </tr> </tbody> </table> </td> </tr> </tbody>
	</table> <!--[if mso]> </td> </tr> </table> <![endif]--> <!--[if (IE)]> </td></tr></table> <![endif]--> </td> </tr>
	</tbody></table>
	<table style=\"border-spacing: 0;border-collapse: collapse;
	vertical-align: top;background-color: #555555\" cellpadding=\"0\"
	cellspacing=\"0\" align=\"center\" width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
			<td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top\" width=\"100%\"> <!--[if gte mso 9]>
			<table id=\"outlookholder\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
				<tr>
					<td>
						<![endif]--> <!--[if (IE)]>
						<table width=\"500\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
							<tr>
								<td>
									<![endif]-->
									 <table class=\"container\"
									 style=\"border-spacing: 0;border-collapse: collapse;vertical-align: top;max-width: 500px;
									 margin: 0 auto;text-align: inherit\"
									 cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" border=\"0\">
							<tbody>
								<tr style=\"vertical-align: top\">
								 <td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top\" width=\"100%\">
								 <table class=\"block-grid mixed-two-up\"
								 style=\"border-spacing: 0;border-collapse: collapse;vertical-align: top;width: 100%;max-width: 500px;color: #333;
								 background-color: transparent\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" bgcolor=\"transparent\">
							<tbody>
								<tr style=\"vertical-align: top\">
									<td style=\"word-break: break-word;border-collapse: collapse !important;
									vertical-align: top;text-align: center;
									font-size: 0\"> <!--[if (gte mso 9)|(IE)]>
									<table width=\"100%\" align=\"center\" bgcolor=\"transparent\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
										<tr>
											<![endif]--><!--[if (gte mso 9)|(IE)]>
											<td valign=\"top\" width=\"167\">
												<![endif]-->
												 <div class=\"col num4\" style=\"display: inline-block;
												 vertical-align: top;
												 text-align: center;
												 width: 167px\">
												 <table style=\"border-spacing: 0;
												 border-collapse: collapse;
												 vertical-align: top\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" border=\"0\">
										<tbody>
											<tr style=\"vertical-align: top\">
											 <td style=\"word-break: break-word;border-collapse: collapse !important;
											 vertical-align: top;
											 background-color: transparent;
											 padding-top: 15px;
											 padding-right: 10px;
											 padding-bottom: 15px;
											 padding-left: 10px;
											 border-top: 0px solid transparent;
											 border-right: 0px solid transparent;
											 border-bottom: 0px solid transparent;
											 border-left: 0px solid transparent\">
											  <table style=\"border-spacing: 0;border-collapse: collapse;
											  vertical-align: top\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
										<tbody>
											<tr style=\"vertical-align: top\">
											 <td style=\"word-break: break-word;border-collapse: collapse !important;
											 vertical-align: top;padding-top: 10px;
											 padding-right: 10px;padding-bottom: 10px;padding-left: 10px\">
											 <div style=\"color:#FFFFFF;line-height:120%;font-family:\'Open Sans\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;\">
											  <div style=\"font-size:12px;
											  line-height:14px;
											  color:#FFFFFF;
											  font-family:\'Open Sans\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;
											  text-align:left;\">
											  <p style=\"margin: 0;font-size: 12px;line-height: 14px\">
											  <span style=\"font-size: 10px; line-height: 12px;\">Booking ID</span></p>
											  <p style=\"margin: 0;font-size: 12px;line-height: 14px\">
											  <strong><span style=\"font-size: 14px; line-height: 16px;\">[TICKET_ID]</span></strong></p> </div> </div> </td> </tr>
										</tbody>
									</table>
									<table style=\"border-spacing: 0;
									border-collapse: collapse;vertical-align: top\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" border=\"0\">
							<tbody>
								<tr style=\"vertical-align: top\">
									<td style=\"word-break: break-word;
									border-collapse: collapse !important;
									vertical-align: top;width: 100%;padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px\" align=\"center\">
									<div style=\"font-size:12px\" align=\"center\">[QR_CODE]</div>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				</tbody>
			</table>
			</div> <!--[if (gte mso 9)|(IE)]> </td> <![endif]--><!--[if (gte mso 9)|(IE)]>
			<td valign=\"top\" width=\"333\">
				<![endif]-->
				<div class=\"col num8\" style=\"display: inline-block;vertical-align: top;
				text-align: center;
				width: 333px\"> <table style=\"border-spacing: 0;
				border-collapse: collapse;vertical-align: top\" cellpadding=\"0\"
				cellspacing=\"0\" align=\"center\" width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
		<td style=\"word-break: break-word;border-collapse: collapse !important;
		vertical-align: top;background-color: transparent;padding-top: 15px;
		padding-right: 0px;padding-bottom: 15px;
		padding-left: 0px;border-top: 0px solid transparent;
		border-right: 0px solid transparent;
		border-bottom: 0px solid transparent;border-left: 0px solid transparent\">
		 <table style=\"border-spacing: 0;border-collapse: collapse;vertical-align: top\"
		 cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
	<tbody>
		<tr style=\"vertical-align: top\">
		<td style=\"word-break: break-word;
		border-collapse: collapse !important;
		vertical-align: top;padding-top: 10px;
		padding-right: 10px;padding-bottom: 10px;
		padding-left: 10px\">
		 <div style=\"color:#FFFFFF;line-height:120%;
		 font-family:\'Open Sans\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;\">
		 <div style=\"font-size:12px;line-height:14px;
		 color:#FFFFFF;font-family:\'Open Sans\', \'Helvetica Neue\',
		  Helvetica, Arial, sans-serif;text-align:left;\">
		   <p style=\"margin: 0;font-size: 14px;line-height: 17px\">
		   <strong><span style=\"font-size: 20px; line-height: 24px;\">[EVENT_NAME]</span>
		   </strong><br><br></p>
		   <p style=\"margin: 0;font-size: 14px;line-height: 16px\">at [EVENT_LOCATION]</p>
		   <p style=\"margin: 0;font-size: 14px;line-height: 16px\">
		   <br>Event Starts : 13th Feb 2016, 9 AM<br>Event Ends &nbsp; : 15th Feb 2016, 6 PM</p> </div> </div> </td> </tr>
	</tbody>
	</table> </td> </tr>
	 </tbody> </table>
	  </div>
	  <!--[if (gte mso 9)|(IE)]> </td> <![endif]-->
	  <!--[if (gte mso 9)|(IE)]>
	  </td> </tr> </table>
	  <![endif]--> </td>
	  </tr> </tbody>
	   </table> </td> </tr>
	   </tbody> </table>
	    <!--[if mso]>
	    </td> </tr>
	     </table> <![endif]--> <!--[if (IE)]> </td>
	      </tr>
	      </table> <![endif]-->
	      </td> </tr> </tbody> </table>
	      <table style=\"border-spacing: 0;border-collapse: collapse;
	      vertical-align: top;
	      background-color: transparent\" cellpadding=\"0\" cellspacing=\"0\"
	      align=\"center\" width=\"100%\" border=\"0\">
	<tbody>
		<tr style=\"vertical-align: top\">
			<td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top\" width=\"100%\"> <!--[if gte mso 9]>
			<table id=\"outlookholder\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">
				<tr>
					<td>
						<![endif]--> <!--[if (IE)]>
						<table width=\"500\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
							<tr>
								<td>
									<![endif]-->
									<table class=\"container\" style=\"border-spacing: 0;border-collapse: collapse;
									vertical-align: top;max-width: 500px;
									margin: 0 auto;
									text-align: inherit\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\"
									border=\"0\">
							<tbody>
								<tr style=\"vertical-align: top\">
								 <td style=\"word-break: break-word;
								 border-collapse: collapse !important;
								 vertical-align: top\" width=\"100%\">
								  <table class=\"block-grid\"
								  style=\"border-spacing: 0;border-collapse: collapse;
								  vertical-align: top;
								  width: 100%;max-width: 500px;
								  color: #000000;
								  background-color: transparent\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" bgcolor=\"transparent\">
							<tbody>
								<tr style=\"vertical-align: top\">
									<td style=\"word-break: break-word;
									border-collapse: collapse !important;
									vertical-align: top;text-align: center;
									font-size: 0\">
									<!--[if (gte mso 9)|(IE)]>
									<table width=\"100%\" align=\"center\" bgcolor=\"transparent\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
										<tr>
											<![endif]--><!--[if (gte mso 9)|(IE)]>
											<td valign=\"top\" width=\"500\">
												<![endif]-->
												 <div class=\"col num12\"
												 style=\"display: inline-block;
												 vertical-align: top;
												 width: 100%\">
												  <table style=\"border-spacing: 0;
												  border-collapse: collapse;
												  vertical-align: top\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"100%\" border=\"0\">
										<tbody>
											<tr style=\"vertical-align: top\">
											 <td style=\"word-break: break-word;
											 border-collapse: collapse !important;
											 vertical-align: top;
											 background-color: transparent;padding-top: 5px;
											 padding-right: 0px;padding-bottom: 5px;
											 padding-left: 0px;
											 border-top: 0px solid transparent;
											 border-right: 0px solid transparent;
											 border-bottom: 0px solid transparent;
											 border-left: 0px solid transparent\">
											 <table style=\"border-spacing: 0;
											 border-collapse: collapse;
											 vertical-align: top\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
										<tbody>
											<tr style=\"vertical-align: top\">
											<td style=\"word-break: break-word;border-collapse: collapse !important;
											vertical-align: top;padding-top: 10px;
											padding-right: 10px;
											padding-bottom: 10px;
											padding-left: 10px\">
											 <div style=\"color:#555555;line-height:120%;font-family:\'Open Sans\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;\">
											 <div style=\"font-size:12px;line-height:14px;color:#555555;
											 font-family:\'Open Sans\', \'Helvetica Neue\', Helvetica, Arial, sans-serif;text-align:left;\"> <p style=\"margin: 0;font-size: 14px;
											 line-height: 17px\">
											 <span style=\"font-size: 11px; line-height: 13px;\">
											 <strong>Important Instructions</strong></span></p> <p style=\"margin: 0;font-size: 14px;line-height: 16px\">
											 <span style=\"font-size: 11px; line-height: 13px;\">Tickets once booked cannot be exchanged, cancelled or refunded.&nbsp;
											 </span></p> </div> </div> </td> </tr>
										</tbody>
									</table>
									</td>
								</tr>
							</tbody>
						</table>
						</div> <!--[if (gte mso 9)|(IE)]>
					</td>
					<![endif]--><!--[if (gte mso 9)|(IE)]></td>
				</tr>
			</table>
			<![endif]--> </td>
		</tr>
	</tbody>
	</table> </td> </tr>
	 </tbody> </table> <!--[if mso]> </td> </tr>
		</table> <![endif]-->
		<!--[if (IE)]> </td> </tr> </table> <![endif]-->
		</td> </tr> </tbody> </table> </td> </tr> </tbody></table> </body>
</html>
0
");
