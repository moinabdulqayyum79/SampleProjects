package com.moin.sechallenge.dto;

import java.util.Objects;

import org.json.JSONObject;

public class ReportDTO {

	private int employeeID;
	private PayPeriodDTO payPeriod;
	private float amount;
	
	public ReportDTO(int employeeID, PayPeriodDTO payPeriod, float amount) {
		super();
		this.employeeID = employeeID;
		this.payPeriod = payPeriod;
		this.amount = amount;
	}

	
	
	public ReportDTO() {
		
	}



	public int getEmployeeID() {
		return employeeID;
	}

	public void setEmployeeID(int employeeID) {
		this.employeeID = employeeID;
	}

	public PayPeriodDTO getPayPeriod() {
		return payPeriod;
	}

	public void setPayPeriod(PayPeriodDTO payPeriod) {
		this.payPeriod = payPeriod;
	}

	public float getAmount() {
		return amount;
	}

	public void setAmount(float amount) {
		this.amount = amount;
	}
	
	public JSONObject toJSON() {
		
		//if(this == null) return null;
		JSONObject object=new JSONObject();
		object.put("employeeID", getEmployeeID());
		object.put("payPeriod", getPayPeriod().toJSON());
		object.put("amount", getAmount());
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
		ReportDTO other = (ReportDTO) obj;
		return Float.floatToIntBits(amount) == Float.floatToIntBits(other.amount) && employeeID == other.employeeID
				&& Objects.equals(payPeriod, other.payPeriod);
	}
	
	
	
}
