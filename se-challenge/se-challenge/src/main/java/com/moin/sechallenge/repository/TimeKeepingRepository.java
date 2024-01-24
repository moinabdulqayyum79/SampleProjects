package com.moin.sechallenge.repository;

import java.time.LocalDate;
import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.moin.sechallenge.model.TimeReportData;


@Repository
public interface TimeKeepingRepository extends JpaRepository<TimeReportData, Integer>{
	List<TimeReportData> findByOrderByEmployeeIdAscDateWorkedAsc();
	
	TimeReportData findByEmployeeIdAndDateWorked(int employeeId, LocalDate dateWorked);
}

