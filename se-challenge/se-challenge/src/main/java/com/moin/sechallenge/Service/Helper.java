package com.moin.sechallenge.Service;

import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.List;

import org.springframework.web.multipart.MultipartFile;

import com.moin.sechallenge.model.Employee;
import com.moin.sechallenge.model.FileUpload;
import com.moin.sechallenge.model.JobGroup;
import com.moin.sechallenge.model.TimeReportData;

public class Helper {

	public static List<TimeReportData> fileToList(MultipartFile file, FileUpload currFile) throws Exception {
		List<TimeReportData> timeKeepingData=new ArrayList<TimeReportData>();
		
		BufferedReader br= new BufferedReader(new InputStreamReader(file.getInputStream()));
		String line=br.readLine();
		while((line=br.readLine())!=null) {
			String [] data=line.split(",");
			DateTimeFormatter dtf=DateTimeFormatter.ofPattern("d/M/yyyy");
			TimeReportData trd=new TimeReportData(LocalDate.parse(data[0],dtf), 
					Float.parseFloat(data[1]), 
					new Employee(Integer.parseInt(data[2])), new JobGroup(data[3]),currFile);
			timeKeepingData.add(trd);
		}
		
		return timeKeepingData;
	}
}
