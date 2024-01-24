package com.moin.sechallenge;

import static org.junit.jupiter.api.Assertions.assertEquals;
import static org.junit.jupiter.api.Assertions.assertNull;
import static org.mockito.ArgumentMatchers.intThat;
import static org.mockito.Mockito.when;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.time.LocalDate;
import java.util.ArrayList;
import java.util.List;


import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.Test;
import org.junit.jupiter.api.extension.ExtendWith;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.Mockito;
import org.mockito.junit.jupiter.MockitoExtension;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.mock.web.MockMultipartFile;
import org.springframework.web.multipart.MultipartFile;

import com.moin.sechallenge.Service.Helper;
import com.moin.sechallenge.Service.TimeKeepingService;
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

@ExtendWith(MockitoExtension.class)
@SpringBootTest
class SeChallengeApplicationTests {

	@Mock
	TimeKeepingRepository tkRepository;
	@Mock
	JobGroupRepository jgRepository;
	@Mock
	FileRepository fRepository;
	@Mock
	EmployeeRepository eRepository;
	@InjectMocks
	TimeKeepingService tkService;
	
	
	static byte[] file1,file2,wrongFile;
	
	static JobGroup jobGroupA;
	static Employee employee1;
	
	static TimeReportData trd1,trd2,trd3,trd4;
	static List<TimeReportData> trdList;
	
	static List<ReportDTO> checkReport;
	
	@BeforeAll
	static void setup() {
		jobGroupA=new JobGroup("A", 20f);
		jobGroupA.setId(1);
		employee1=new Employee(1);
		employee1.setId(1);
		try {
			file1=Files.readAllBytes(Paths.get("./src/test/resources/time-report-1.csv"));
			file2=Files.readAllBytes(Paths.get("./src/test/resources/time-report-2.csv"));
			wrongFile=Files.readAllBytes(Paths.get("./src/test/resources/time-report-1-copy.csv"));
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
		
		trd1=new TimeReportData(LocalDate.of(2023, 1, 4),10f,
				new Employee(1), new JobGroup("A",20f),new FileUpload(1));
		trd2=new TimeReportData(LocalDate.of(2023, 1, 14),5f,
				new Employee(1), new JobGroup("A",20f),new FileUpload(1));
		trd3=new TimeReportData(LocalDate.of(2023, 1, 20),3f,
				new Employee(2), new JobGroup("B",30f),new FileUpload(1));
		trd4=new TimeReportData(LocalDate.of(2023, 1, 20),4f,
				new Employee(1), new JobGroup("A",20f),new FileUpload(1));
		
		trdList= new ArrayList<TimeReportData>();
		
		trdList.add(trd1);
		trdList.add(trd2);
		trdList.add(trd4);
		trdList.add(trd3);
		
		checkReport=new ArrayList<ReportDTO>();
		checkReport.add(new ReportDTO(1,
				new PayPeriodDTO(LocalDate.of(2023, 1, 1), LocalDate.of(2023, 1, 15)),300f));
		checkReport.add(new ReportDTO(1,
				new PayPeriodDTO(LocalDate.of(2023, 1, 16), LocalDate.of(2023, 1, 31)),80f));
		checkReport.add(new ReportDTO(2,
				new PayPeriodDTO(LocalDate.of(2023, 1, 16), LocalDate.of(2023, 1, 31)),90f));
	}
	//successfully convert file to list of data
	
	@Test
	void fileToList_Success() {
		MultipartFile mpFile1=new MockMultipartFile("time-report-1.csv","time-report-1.csv","text/csv", file1);
		TimeReportData trd=new TimeReportData(LocalDate.of(2001, 9, 7), 10f, 
				new Employee(1), new JobGroup("A"), new FileUpload(1));
		List<TimeReportData> data=null;
		try {
			data=Helper.fileToList(mpFile1, new FileUpload(1));
		} catch (Exception e) {
		}
		assertEquals(trd, data.get(0));
		
	}
	
	//failure in converting file
	@Test
	void fileToList_Failure() {
		MultipartFile mpFile2=new MockMultipartFile("time-report-2.csv","time-report-2.csv","text/csv", file2);
		List<TimeReportData> data=null;
		try {
			data=Helper.fileToList(mpFile2, new FileUpload(1));
		} catch (Exception e) {
		}
		assertNull(data);
	}
	
	@Test
	void insertData_WrongFile() {
		when(jgRepository.countByJobGroupName(Mockito.any(String.class))).thenReturn(0l);
		
		MultipartFile wrongMPFile=new MockMultipartFile("time-report-1-copy.csv","time-report-1-copy.csv","text/csv", wrongFile);
		InsertDataStatusDTO statusDTO= tkService.insertData(wrongMPFile);
		InsertDataStatusDTO checkStatus= new InsertDataStatusDTO("Upload correct file!");
		
		
		
		assertEquals(statusDTO, checkStatus);
		
	}
	
	@Test
	void insertData_FileError() {
		when(jgRepository.countByJobGroupName(Mockito.any(String.class))).thenReturn(1l);
		when(fRepository.existsById(Mockito.any(Integer.class))).thenReturn(false);
		when(fRepository.save(Mockito.any(FileUpload.class))).thenReturn(null);
		
		MultipartFile mpFile2=new MockMultipartFile("time-report-2.csv","time-report-2.csv","text/csv", file2);
		InsertDataStatusDTO statusDTO= tkService.insertData(mpFile2);
		InsertDataStatusDTO checkStatus= new InsertDataStatusDTO("Something went wrong with the file upload.");
		assertEquals(statusDTO, checkStatus);
		
	}
	
	@Test
	void insertData_Successfull() {
		when(jgRepository.countByJobGroupName(Mockito.any(String.class))).thenReturn(1l);
		when(fRepository.existsById(Mockito.any(Integer.class))).thenReturn(false);
		when(fRepository.save(Mockito.any(FileUpload.class))).thenReturn(null);
		when(jgRepository.findByJobGroupName("A")).thenReturn(jobGroupA);
		when(eRepository.findByEmployeeId(1)).thenReturn(employee1);
		when(tkRepository.findByEmployeeIdAndDateWorked(1, LocalDate.of(2001, 9, 7))).thenReturn(null);
		when(tkRepository.saveAll(Mockito.any())).thenReturn(null);
		
		MultipartFile mpFile1=new MockMultipartFile("time-report-1.csv","time-report-1.csv","text/csv", file1);
		InsertDataStatusDTO statusDTO=tkService.insertData(mpFile1);
		InsertDataStatusDTO checkStatus=new InsertDataStatusDTO("Successful");
		
		
		assertEquals(statusDTO, checkStatus);
	}

	@Test
	void getReport_DataPresent() {
		when(tkRepository.findByOrderByEmployeeIdAscDateWorkedAsc()).thenReturn(trdList);
		List<ReportDTO> report= tkService.getReport();
		//System.out.println(report.to)
		for(int i=0;i<report.size();i++) {
			assertEquals(report.get(i), checkReport.get(i));
		}
	}
	
	@Test
	void getReport_Null() {
		when(tkRepository.findByOrderByEmployeeIdAscDateWorkedAsc()).thenReturn(new ArrayList<TimeReportData>());
		
		List<ReportDTO> report=tkService.getReport();
		
		assertNull(report);
	}
}
