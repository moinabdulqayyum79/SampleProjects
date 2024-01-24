package com.moin.sechallenge.model;

import java.time.LocalDate;
import java.util.Objects;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.SequenceGenerator;

@Entity
public class TimeReportData {
	
	@Id
	@SequenceGenerator(
			name="time_report_sequence",
			sequenceName = "time_report_sequence",
			allocationSize = 1
			)
	@GeneratedValue(
			generator = "time_report_sequence",
			strategy = GenerationType.SEQUENCE
			)
	private int id;
	@Column(
			columnDefinition = "date"
			)
	private LocalDate dateWorked;
	private Float hours;
	@ManyToOne
	private Employee employee;
	@ManyToOne
	private JobGroup jobGroup;
	@ManyToOne
	private FileUpload fileId;
	
	
	public TimeReportData(LocalDate dateWorked, Float hours, Employee employee, JobGroup jobGroup, FileUpload fileId) {
		super();
		this.dateWorked = dateWorked;
		this.hours = hours;
		this.employee = employee;
		this.jobGroup = jobGroup;
		this.fileId = fileId;
	}
	public TimeReportData() {
	}
	public LocalDate getDateWorked() {
		return dateWorked;
	}
	public void setDateWorked(LocalDate dateWorked) {
		this.dateWorked = dateWorked;
	}
	public Float getHours() {
		return hours;
	}
	public void setHours(Float hours) {
		this.hours = hours;
	}
	public Employee getEmployee() {
		return employee;
	}
	public void setEmployee(Employee employee) {
		this.employee = employee;
	}
	public JobGroup getJobGroup() {
		return jobGroup;
	}
	public void setJobGroup(JobGroup jobGroup) {
		this.jobGroup = jobGroup;
	}
	public FileUpload getFile() {
		return fileId;
	}
	public void setFileId(FileUpload fileId) {
		this.fileId = fileId;
	}
	
	@Override
	public String toString() {
		return "TimeReportData [id=" + id + ", dateWorked=" + dateWorked + ", hours=" + hours + ", employee=" + employee
				+ ", jobGroup=" + jobGroup + ", fileId=" + fileId + "]";
	}
	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		TimeReportData other = (TimeReportData) obj;
		return Objects.equals(dateWorked, other.dateWorked) && Objects.equals(employee, other.employee)
				&& Objects.equals(fileId, other.fileId) && Objects.equals(hours, other.hours) && id == other.id
				&& Objects.equals(jobGroup, other.jobGroup);
	}
	
	
	
	

}
