package com.moin.sechallenge.model;

import java.util.Objects;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.SequenceGenerator;

@Entity
public class Employee {
	
	@Id
	@SequenceGenerator(
			name="employee_id_sequence",
			sequenceName = "employee_id_sequence",
			allocationSize = 1
			)
	@GeneratedValue(
			generator = "employee_id_sequence",
			strategy = GenerationType.SEQUENCE
			)
	@Column(
			updatable = false
			)
	private int id;
	
	@Column(
			unique = true
			)
	private int employeeId;
	
	private String firstName;
	private String lastName;
	
	public Employee() {
	}
	
	public Employee(Integer employeeId) {
		this.employeeId=employeeId;
	}
	

	public Employee(Integer employeeId, String firstName, String lastName) {
		super();
		this.employeeId = employeeId;
		this.firstName = firstName;
		this.lastName = lastName;
	}
	
	

	

	public int getId() {
		return id;
	}


	public void setId(int id) {
		this.id = id;
	}


	public Integer getEmployeeId() {
		return employeeId;
	}

	public void setEmployeeId(Integer employeeId) {
		this.employeeId = employeeId;
	}

	public String getFirstName() {
		return firstName;
	}

	public void setFirstName(String firstName) {
		this.firstName = firstName;
	}

	public String getLastName() {
		return lastName;
	}

	public void setLastName(String lastName) {
		this.lastName = lastName;
	}

	@Override
	public String toString() {
		return "Employee [employeeId=" + employeeId + 
				", firstName=" + firstName + 
				", lastName=" + lastName + "]";
	}


	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		Employee other = (Employee) obj;
		return employeeId == other.employeeId && Objects.equals(firstName, other.firstName) && id == other.id
				&& Objects.equals(lastName, other.lastName);
	}
	
	
	
}
