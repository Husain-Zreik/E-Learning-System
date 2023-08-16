import { Routes, Route } from "react-router-dom";
import TeacherLayout from "./utils/TeacherLayout/TeacherLayout";
import TeacherHome from "./pages/Teacher/Home/TeacherHome";
import Course from "./pages/Teacher/Course/Course";
import Attendance from "./pages/Teacher/Attendance/Attendance";
import Grades from "./pages/Teacher/Grades/Grades";
import Landing from "./pages/Student/landing/landing";
import Login from "./pages/login/login";
import AdminLayout from "./utils/AdminLayout";
import AdminHome from "./pages/Admin/Home";
import Create from "./pages/Admin/Create";
import Display from "./pages/Admin/Display";
import Settings from "./pages/Admin/Settings";
import StudentLayout from "./utils/StudentLayout/StudentLayout";
import Inprogress from "./pages/Student/inprogress/inprogress";
import Completed from "./pages/Student/completed/completed";
import CoursePage from "./pages/Student/coursePage/CoursePage";

function App() {
  return (
    <div className="routes dark">
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/register" element={<h1>Register</h1>} />
        <Route path="/" element={<h1>Login</h1>} />

        <Route path="/admin" element={<AdminLayout />}>
          <Route index element={<AdminHome />} />
          <Route path="/admin/create" element={<Create />} />
          <Route path="/admin/display" element={<Display />} />
          <Route path="/admin/settings" element={<Settings />} />
        </Route>

        <Route path="/student" element={<StudentLayout />}>
          <Route index element={<Landing />} />
          <Route path="inprogress" element={<Inprogress />} />
          <Route path="completed" element={<Completed />} />
          <Route path="course/:id/:name" element={<CoursePage />} />
        </Route>

        <Route path="/teacher" element={<TeacherLayout />}>
          <Route index element={<TeacherHome />} />
          <Route path="/teacher/course/:id" element={<Course />} />
          <Route
            path="/teacher/course/:id/attendance"
            element={<Attendance />}
          />
          <Route
            path="/teacher/course/:id/assignment/:id"
            element={<Grades />}
          />
        </Route>

        <Route path="/parent">
          <Route index element={<h1>Parent</h1>} />
        </Route>
      </Routes>
    </div>
  );
}

export default App;
