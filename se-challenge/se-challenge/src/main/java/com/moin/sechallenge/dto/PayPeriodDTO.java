package com.moin.sechallenge.dto;

import java.time.LocalDate;
import java.util.Objects;

import org.json.JSONObject;

public class PayPeriodDTO {

	private LocalDate startDate;
	private LocalDate endDate;
	
	public PayPeriodDTO(LocalDate startDate, LocalDate endDate) {
		this.startDate = startDate;
		this.endDate = endDate;
	}
	
	
	
	public LocalDate getStartDate() {
		return startDate;
	}



	public void setStartDate(LocalDate startDate) {
		this.startDate = startDate;
	}



	public LocalDate getEndDate() {
		return endDate;
	}



	public void setEndDate(LocalDate endDate) {
		this.endDate = endDate;
	}



	public JSONObject toJSON() {
		JSONObject object=new JSONObject();
		object.put("startDate", getStartDate());
		object.put("endDate", getEndDate());
		return object;
	}



	
	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		PayPeriodDTO other = (PayPeriodDTO) obj;
		return Objects.equals(endDate, other.endDate) && Objects.equals(startDate, other.startDate);
	}
	
	
	
}
