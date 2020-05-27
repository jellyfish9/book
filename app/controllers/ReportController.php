<?php 

/**
 * Report Page Controller
 * @category  Controller
 */
class ReportController extends SecureController{
	/**
     * Render All Records  in a  Data Table 
     * @return Html View
     */
	function index(){
		$this->view->render("report/index.php" ,null,"report_layout.php");
	}
}
