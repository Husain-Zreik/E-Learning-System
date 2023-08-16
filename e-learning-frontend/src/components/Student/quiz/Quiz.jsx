import React, { useEffect, useState } from "react";
import "./quiz.css";
import axios from "axios";

function Quiz({ quizData, param }) {
  const [uploadedFile, setUploadedFile] = useState(null);
  const [quizSubmited, setQuizSubmited] = useState(false);

  const handleFileUpload = (event) => {
    const file = event.target.files[0];
    setUploadedFile(file);
  };
  console.log(uploadedFile);
  const submitData = async () => {
    const data = new FormData();
    data.append("video", uploadedFile);
    data.append("title", "1111");
    data.append("description", "123456");
    data.append("is_announcement", "0");
    // data.append("assignment_id", quizData.id);

    try {
      const response = await axios.post(
        "http://127.0.0.1:8000/api/user/shared/2/create-material",
        data
      );
      console.log(response);
    } catch (error) {
      console.error(error);
    }
  };
  const isSumbit = async () => {
    try {
      const response = await axios.get(
        "http://127.0.0.1:8000/api/user/shared/get_is_submited"
      );
      console.log(response.data.data);
      const data = await response.data.data;

      data.forEach((ele) => {
        if (
          ele.submission_data.assignment_quiz.course_id == param.id &&
          ele.submission_data.assignment_id == quizData.id
        ) {
          return setQuizSubmited(true);
        } else {
          setQuizSubmited(false);
        }
      });
    } catch (error) {
      console.error(error);
    }
  };
  console.log(quizSubmited);
  useEffect(() => {
    isSumbit();
  }, [quizData.id]);
  return (
    <div className="quiz-container">
      <div className="quizinfo">
        <h3>{quizData.title}</h3>
        <p>Deadline: {quizData.deadline}</p>
        <p>Grade: {quizData.grade}</p>
      </div>
      <p>{quizData.description}</p>
      <div className="file">
        {quizData.file_url ? (
          <div>
            <a
              href={quizData.file_url}
              target="_blank"
              rel="noopener noreferrer">
              {quizData.title} - File
            </a>
          </div>
        ) : (
          <p>No file available for this quiz.</p>
        )}
        <div className="buttonquiz">
          <div className="inputfile">
            <label htmlFor="submit" className="submitBtn">
              Upload
            </label>
            <input type="file" id="submit" onChange={handleFileUpload} />
          </div>
          {!quizSubmited ? (
            <div className="submitBtn" onClick={submitData}>
              Submit
            </div>
          ) : (
            <div className="submitBtn">Submited</div>
          )}
        </div>
      </div>
      <p>Created on: {quizData.created_at.split("T")[0]}</p>
    </div>
  );
}

export default Quiz;