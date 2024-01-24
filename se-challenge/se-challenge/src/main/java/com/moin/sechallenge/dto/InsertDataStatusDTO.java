package com.moin.sechallenge.dto;

import java.util.Objects;

import org.json.JSONObject;

public class InsertDataStatusDTO {
	private String status;

	public InsertDataStatusDTO(String status) {
		this.status = status;
	}

	public String getStatus() {
		return status;
	}

	public void setStatus(String status) {
		this.status = status;
	}
	
	public JSONObject toJSON() {
		JSONObject object=new JSONObject();
		object.put("status", getStatus());
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
		InsertDataStatusDTO other = (InsertDataStatusDTO) obj;
		return Objects.equals(status, other.status);
	}

	
}
