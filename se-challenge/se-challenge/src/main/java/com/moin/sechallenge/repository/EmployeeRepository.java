package com.moin.sechallenge.repository;



import org.springframework.data.jpa.repository.JpaRepository;

import com.moin.sechallenge.model.Employee;

public interface EmployeeRepository extends JpaRepository<Employee, Integer> {

	long countByEmployeeId(int employeeId);
	Employee findByEmployeeId(int employeeId);
}
