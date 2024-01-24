package com.moin.sechallenge.controller;

import java.util.ArrayList;
import java.util.List;

import org.json.JSONArray;
import org.json.JSONObject;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.multipart.MultipartFile;

import com.moin.sechallenge.Service.TimeKeepingService;
import com.moin.sechallenge.dto.ReportDTO;

@RestController
@RequestMapping("/time-keeping")
public class TimeKeepingController {
	@Autowired
	TimeKeepingService tKService;
	@PostMapping
	public String fileUpload(@RequestParam("file") MultipartFile file) {
		
		return tKService.insertData(file).toJSON().toString();
	}
	
	@GetMapping
	public String getPayrollReport() {
		JSONArray reportsArray=new JSONArray();
		List<ReportDTO> reportsList = tKService.getReport();
		if(reportsList!=null)
			for (ReportDTO object : reportsList) {
				reportsArray.put(object.toJSON());
			}
		JSONObject employeeReports=new JSONObject();
		employeeReports.put("employeeReports", reportsArray);
		JSONObject payrollReport=new JSONObject();
		payrollReport.put("payrollReport", employeeReports);
		return payrollReport.toString();
		
	}

}
