package com.moin.sechallenge.Service;


import java.time.LocalDate;
import java.time.YearMonth;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.regex.Pattern;

import org.json.JSONArray;
import org.json.JSONObject;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.web.multipart.MultipartFile;

import com.moin.sechallenge.dto.InsertDataStatusDTO;
import com.moin.sechallenge.dto.PayPeriodDTO;
import com.moin.sechallenge.dto.ReportDTO;
import com.moin.sechallenge.model.Employee;
import com.moin.sechallenge.model.FileUpload;
import com.moin.sechallenge.model.JobGroup;
import com.moin.sechallenge.model.TimeReportData;
import com.moin.sechallenge.repository.EmployeeRepository;
import com.moin.sechallenge.repository.FileRepository;
import com.moin.sechallenge.repository.JobGroupRepository;
import com.moin.sechallenge.repository.TimeKeepingRepository;

@Service
public class TimeKeepingService {

	@Autowired
	private TimeKeepingRepository timeKeepingRepository;
	@Autowired
	private FileRepository fileRepository;
	@Autowired
	private EmployeeRepository employeeRepository;
	@Autowired
	private JobGroupRepository jobGroupRepository;
	
	private HashMap<String, JobGroup> jobGroupsMap;
	
	private HashMap<Integer, Employee> employeesMap;
	
	List<JobGroup> jobGroups;
	
	List<Employee> employees;
	
	
	public InsertDataStatusDTO insertData(MultipartFile file) {

//		if(jobGroupRepository.countByJobGroupName("A")==0) 
//			jobGroupRepository.save(new JobGroup("A", 20f));
//		if(jobGroupRepository.countByJobGroupName("B")==0) 
//			jobGroupRepository.save(new JobGroup("B", 30f));
		
		if(jobGroups == null) {
			jobGroupsMap=new HashMap<>();
			employeesMap=new HashMap<>();
			jobGroups=new ArrayList<JobGroup>();
			employees=new ArrayList<Employee>();
			
			jobGroups=jobGroupRepository.findAll();
			employees=employeeRepository.findAll();
			
			for (Employee employee : employees) {
				employeesMap.put(employee.getEmployeeId(), employee);
			}
			for (JobGroup jobGroup : jobGroups) {
				jobGroupsMap.put(jobGroup.getJobGroup(), jobGroup);
			}
			
		}
		
		InsertDataStatusDTO statusDTO;
		String response;
		
		try {
			if(checkFile(file)) {
				int fileId=Integer.parseInt(file.getOriginalFilename().split("\\.")[0].split("-")[2]);
				if(!fileRepository.existsById(fileId)) {
					FileUpload currFile=new FileUpload(fileId);
					fileRepository.save(currFile);
					response=addToDB(Helper.fileToList(file, currFile));
				}
				else {
					response ="Cannot re-upload file!";
				}
				
			}
			else {
				response="Upload correct file!";
			}
		} catch (Exception e) {
			// TODO Auto-generated catch block
			//e.printStackTrace();
			response="Something went wrong with the file upload.";
			
		}
		statusDTO= new InsertDataStatusDTO(response);
		
		return statusDTO;
		
	}
	
	public List<ReportDTO> getReport() {
		
		List<TimeReportData> list=timeKeepingRepository.findByOrderByEmployeeIdAscDateWorkedAsc();
		
		return generateReport(list);
	}
	
	//Helper methods
	
	private List<ReportDTO> generateReport(List<TimeReportData> list) {
		
		if(list.size()==0) {
			return null;
		}
		ReportDTO report = new ReportDTO();
		List<ReportDTO> reportsArray= new ArrayList<ReportDTO>();
		PayPeriodDTO payPeriod;
		
		float hours=0;
		TimeReportData curr=list.get(0);
		LocalDate [] startEndDates=getStartEndDates(curr.getDateWorked());
		int employeeID=curr.getEmployee().getEmployeeId();
		payPeriod= new PayPeriodDTO(startEndDates[0], startEndDates[1]);
		report.setEmployeeID(employeeID);
		report.setPayPeriod(payPeriod);
		float wage=curr.getJobGroup().getWage();
		hours+= curr.getHours();
		for(int i=1;i<list.size();i++) {
			curr=list.get(i);
			LocalDate [] currDates=getStartEndDates(curr.getDateWorked());
			int currID=curr.getEmployee().getEmployeeId();
			if(currID==employeeID && startEndDates[0].equals(currDates[0])) {
				hours+=curr.getHours();
			}
			else {
				report.setAmount(hours*wage);
				reportsArray.add(report);
				startEndDates[0]=currDates[0];
				startEndDates[1]=currDates[1];
				employeeID=currID;
				wage=curr.getJobGroup().getWage();
				hours=curr.getHours();
				payPeriod= new PayPeriodDTO(startEndDates[0], startEndDates[1]);
				report=new ReportDTO();
				report.setEmployeeID(employeeID);
				report.setPayPeriod(payPeriod);
			}
		}
		report.setAmount(hours*wage);
		reportsArray.add(report);
		
		return reportsArray;
	}
	
	private String addToDB(List<TimeReportData> trd) {
		for (TimeReportData row : trd) {
			String jobGroupName=row.getJobGroup().getJobGroup();
			int empId = row.getEmployee().getEmployeeId();
			//ensure the job group exists

		
			if(!jobGroupsMap.containsKey(jobGroupName))
				return "Job group does not exist";
			
			JobGroup jGroup= jobGroupsMap.get(jobGroupName);
			int id=jGroup.getId();
			row.getJobGroup().setId(id);;
			
			//check if employee exist, else insert employee
			Employee emp ;
			if(!employeesMap.containsKey(empId)) {
				emp= employeeRepository.save(row.getEmployee());
				employees.add(emp);
				employeesMap.put(emp.getEmployeeId(), emp);
			}
			emp=employeesMap.get(empId);
			id=emp.getId();
			
			//check if an employee data for this date already exists
			TimeReportData checkRow=timeKeepingRepository.findByEmployeeIdAndDateWorked(id, row.getDateWorked());
			if(checkRow!= null)
				return "Data for Employee "+id+" on date "+row.getDateWorked()+" also exists in file ID "
			+checkRow.getFile().getFileId();
			
			row.getEmployee().setId(id);
		}
		timeKeepingRepository.saveAll(trd);
		return "Successful";
	}
	
	private boolean checkFile(MultipartFile file) {
		
		return checkFileName(file) && checkFileType(file);
	}
	private boolean checkFileType(MultipartFile file) {
		return file.getContentType().equals("text/csv");
	}
	private boolean checkFileName(MultipartFile file) {
		
		String name=file.getOriginalFilename().split("\\.")[0];
		
		String regex="time-report-[\\d]+";
		return Pattern.matches(regex, name);
		
	}
	private LocalDate[] getStartEndDates(LocalDate date) {
		int day=date.getDayOfMonth();
		LocalDate startDate,endDate;
		if(day<=15) {
			startDate=LocalDate.of(date.getYear(), date.getMonth(), 1);
			endDate=LocalDate.of(date.getYear(), date.getMonth(), 15);
		}
		else {
			startDate=LocalDate.of(date.getYear(), date.getMonth(), 16);
			YearMonth ym=YearMonth.from(date);
			endDate=ym.atEndOfMonth();
		}
		LocalDate [] startEndDates=new LocalDate[2];
		startEndDates[0]=startDate;
		startEndDates[1]=endDate;
		return startEndDates;
	}

}
