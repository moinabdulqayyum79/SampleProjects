package com.moin.sechallenge.model;

import java.util.Objects;

import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.SequenceGenerator;

@Entity
public class JobGroup {
	
	@Id
	@SequenceGenerator(
			name="job_group_sequence",
			sequenceName = "job_group_sequence",
			allocationSize = 1
			)
	@GeneratedValue(
			generator = "job_group_sequence",
			strategy = GenerationType.SEQUENCE
			)
	private int id;
	private String jobGroupName;
	private float wage;
	
	public JobGroup(String jobGroup) {
		this.jobGroupName = jobGroup;
	}
	public JobGroup() {
	}
	public JobGroup(String jobGroup, Float wage) {
		super();
		this.jobGroupName = jobGroup;
		this.wage = wage;
	}
	
	

	public int getId() {
		return id;
	}



	public void setId(int id) {
		this.id = id;
	}



	public String getJobGroup() {
		return jobGroupName;
	}

	public void setJobGroup(String jobGroup) {
		this.jobGroupName = jobGroup;
	}

	public Float getWage() {
		return wage;
	}

	public void setWage(Float wage) {
		this.wage = wage;
	}

	@Override
	public String toString() {
		return "JobGroup [jobGroup=" + jobGroupName + ", wage=" + wage + "]";
	}
	
	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		JobGroup other = (JobGroup) obj;
		return id == other.id && Objects.equals(jobGroupName, other.jobGroupName)
				&& Float.floatToIntBits(wage) == Float.floatToIntBits(other.wage);
	}
	
	
	
	
}
