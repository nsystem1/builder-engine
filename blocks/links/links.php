<?
/***********************************************************
* BuilderEngine v2.0.12
* ---------------------------------
* BuilderEngine CMS Platform - Radian Enterprise Systems Limited
* Copyright Radian Enterprise Systems Limited 2012-2014. All Rights Reserved.
*
* http://www.builderengine.com
* Email: info@builderengine.com
* Time: 2014-23-04 | File version: 2.0.12
*
***********************************************************/

	class links_block_handler extends  block_handler{
		function info()
		{
			$info['category_name'] = "";
			$info['category_icon'] = "dsf";

			$info['block_name'] = "Links";
			$info['block_icon'] = "fa-envelope-o";
			
			return $info;
		}
		public function generate_admin()
		{
			$title = $this->block->data('title');
			$slide_titles = $this->block->data('slide_title');
			$slide_url = $this->block->data('slide_url');
			$slide_images = $this->block->data('slide_image');
			$slide_texts = $this->block->data('slide_text');
			
			if(!is_array($slide_titles) || empty($slide_titles))
			{
				$title = "BuilderEngine Links";
				$slide_titles[0] = "Example Slide";
				$slide_url[0] = "#";
				$slide_images[0] = "http://www.asge.org/uploadedImages/Patients/National_Colorectal_Cancer_Awareness_Month/NCCAM_Banner_36x12.jpg";
				$slide_texts[0] = "This is a nice new slider. Click edit to customize.";

			}
			$num_slides = count($slide_titles);
			?>

			<!-- Nav tabs -->
    		<script>
    		var num_slides = <?=$num_slides?>;
    		<? if($num_slides == 0): ?>
    		var num_slides = 1;
        	<? endif;?>

    		$(document).ready(function (){
	    		$("#myTab a").click(function (e) {
				  e.preventDefault();
				  $(this).tab("show");
				});

	    		$(".delete-slide").bind("click.delete_slide",function (e) {
	    			slide = $(this).attr('slide');
	    			$("#slide-section-" + slide).remove();
	    			$("#slide-section-tab-" + slide).remove();

	    		});

				$("#add-slide").click(function (e) {
					num_slides++;
					$("#slide-section-tabs").append('<li id="slide-section-tab-' + num_slides +'"><a href="#slide-section-' + num_slides + '" data-toggle="tab">Slide ' + num_slides + '</a></li>');
				
					$("#slide-sections").append('\
						<div class="tab-pane" id="slide-section-' + num_slides + '">\
		                  \
		                </div>\
			                ');
					e.preventDefault();

					html = $("#slide-section-1").html();
					$("#slide-section-" + num_slides).html(html);
					$('#slides a:last').tab('show');
					$('#slide-section-' + num_slides).find('[name="slide_image[0]"]').attr('name', 'slide_image[' + (num_slides-1) + ']');
					$('#slide-section-' + num_slides).find('.delete-slide').attr('slide', num_slides);
					$('#slide-section-' + num_slides).find('[name="slide_title[0]"]').attr('name', 'slide_title[' + (num_slides-1) + ']');
					$('#slide-section-' + num_slides).find('[name="slide_url[0]"]').attr('name', 'slide_url[' + (num_slides-1) + ']');
					$('#slide-section-' + num_slides).find('[name="slide_text[0]"]').attr('name', 'slide_text[' + (num_slides-1) + ']');
					$('#slide-section-' + num_slides).find('[name="slide_image[0]_old"]').attr('onclick', 'file_manager(\'slide_image[' + (num_slides-1) + ']\')');
					$('#slide-section-' + num_slides).find('[name="slide_image[0]_old"]').attr('name', 'slide_image[' + (num_slides-1) + ']_old');
					$(".delete-slide").unbind("click.delete_slide");
					$(".delete-slide").bind("click.delete_slide",function (e) {
		    			slide = $(this).attr('slide');
		    			$("#slide-section-" + slide).remove();
		    			$("#slide-section-tab-" + slide).remove();
		    			$('#slides a:first').tab('show');
		    		});
				});
			});
			</script>
			<div style="border-width: 1px;border-color: #ddd;border-radius: 4px 4px 0 0;border-style: solid;">
				<ul id="myTab" class="nav nav-tabs">
					<li class="active"><a href="#general" data-toggle="tab">General</a></li>
				  	<li><a href="#slides" data-toggle="tab">Slides</a></li>

				</ul>

				<!-- Tab panes -->
				<div class="tab-content">

					<div class="tab-pane active" id="general">
			  		<?
					$this->admin_input('title','text', 'Title: ', $title);
					?>
					</div>

				<div class="tab-pane" id="slides">

					<div class="tabbable tabs-left">
		              <ul class="nav nav-tabs" id="slide-section-tabs">
		              	<li><span id="add-slide" class="btn bt-primary">Add Link</span></li>
		              	<? for($i = 0; $i < $num_slides; $i++): ?>
		                <li class="<?if($i == 0) echo'active'?>" id="slide-section-tab-<?=$i+1?>"><a href="#slide-section-<?=$i+1?>" data-toggle="tab">Slide <?=$i+1?></a></li>
		            	<? endfor; ?>

		            	<? if($num_slides == 0): ?>
		                <li class="active"><a href="#slide-section-1" data-toggle="tab">Link 1</a></li>
		            	<? endif;?>
		              

		              </ul>
		              <div class="tab-content" id="slide-sections">
		              	<? for($i = 0; $i < $num_slides; $i++): ?>
		                <div class="tab-pane <?if($i == 0) echo'active'?>" id="slide-section-<?=$i+1?>">
		                  <?
						$this->admin_input('slide_title['.$i.']','text','Title: ', $slide_titles[$i]);
						$this->admin_input('slide_url['.$i.']','text','Link Address: ', $slide_url[$i]);
						?>
						<span class="btn btn-warn delete-slide" slide="<?=$i+1?>">Delete Link</span>
		                </div>
		            	<? endfor; ?>


		            	<? if($num_slides == 0): ?>
		                <div class="tab-pane active" id="slide-section-1">
		                  <?
						$this->admin_input('slide_title[0]','text','Title: ');
						$this->admin_input('slide_url[0]','text','Link Address: ');

						?>
		                </div>
		            	<? endif;?>

		              </div>
		            </div>
		            
				</div>

				</div>
			</div>
			<?
			

		}
		public function generate_content()
		{
			$slide_titles = $this->block->data('slide_title');


			if(!is_array($slide_titles) || empty($slide_titles))
			{
				$this->block->force_data_modification();
				$this->block->set_data('title', "Example title");
				
				$this->block->set_data('slide_title', array("BuilderEngine.com ¦ Cloud Website Builder","BuilderEngine.net ¦ Cloud Servers & Services","BuilderEngine.org ¦ Open Source CMS"));
				$this->block->set_data('slide_url', array("http://www.builderengine.com","http://www.builderengine.net","http://www.builderengine.org"));
					}
			return $this->output();
			
		}

		function output()
		{
			$title = $this->block->data('title');

			$output = "<div class=\"widget\">
				<h4>{$title}</h4>
				<ul>
			";

            $slide_titles = $this->block->data('slide_title');
			$slide_images = $this->block->data('slide_image');
			$slide_texts = $this->block->data('slide_text');
			$slide_urls = $this->block->data('slide_url');
			$num_slides = count($slide_titles);
			for($i = 0; $i < $num_slides; $i++)
			{

				$output .= "
					<li><a href='{$slide_urls[$i]}'>".$slide_titles[$i]."</a></li>
				";
			}
            $output .= "
            </ul>
            </div>
			";
			return $output;
		}
	}
?>