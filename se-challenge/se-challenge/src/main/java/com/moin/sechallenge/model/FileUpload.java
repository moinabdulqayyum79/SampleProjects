package com.moin.sechallenge.model;



import jakarta.persistence.Entity;
import jakarta.persistence.Id;

@Entity
public class FileUpload {

	@Id
	private int fileId;
	
	
	
	public FileUpload() {
		super();
	}
	public FileUpload(int fileId) {
		this.fileId = fileId;
	}
	public int getFileId() {
		return fileId;
	}
	public void setFileId(int fileId) {
		this.fileId = fileId;
	}
	
	@Override
	public String toString() {
		return "FileUpload [fileId=" + fileId + "]";
	}
	
	@Override
	public boolean equals(Object obj) {
		if (this == obj)
			return true;
		if (obj == null)
			return false;
		if (getClass() != obj.getClass())
			return false;
		FileUpload other = (FileUpload) obj;
		return fileId == other.fileId;
	}
	
	
}
