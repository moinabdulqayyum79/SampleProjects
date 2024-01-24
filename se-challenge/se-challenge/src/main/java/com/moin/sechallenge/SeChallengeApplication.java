package com.moin.sechallenge;

import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;

import com.moin.sechallenge.model.JobGroup;
import com.moin.sechallenge.repository.JobGroupRepository;

@SpringBootApplication
public class SeChallengeApplication {

	public static void main(String[] args) {
		SpringApplication.run(SeChallengeApplication.class, args);
	}
	
	@Bean
	public CommandLineRunner startUpData(JobGroupRepository jobGroupRepository) {
		return args ->{
			if(jobGroupRepository.countByJobGroupName("A")==0) 
				jobGroupRepository.save(new JobGroup("A", 20f));
			if(jobGroupRepository.countByJobGroupName("B")==0) 
				jobGroupRepository.save(new JobGroup("B", 30f));
		};
	}

}
