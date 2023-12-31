import {useState} from "react";
import "./style.css"
import {LiaPaperPlaneSolid} from "react-icons/lia";
import {useParams} from "react-router-dom/dist/umd/react-router-dom.development";
import axios from "axios";

const AnnouncementForm = ({materials, setMaterials}) => {

    const {id} = useParams()
    let [title,
        setTitle] = useState("")
    let [desc,
        setDesc] = useState("")

    const handleAnnounce = async() => {
        let body = {
            title,
            description: desc,
            is_announcement: true
        }
        try {
            const token = localStorage.getItem("jwtToken");
            let {data} = await axios.post(`http://127.0.0.1:8000/api/user/teacher/${id}/create-material`, body, {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            setMaterials(prev => [
                data.content, ...prev
            ])
            setTitle("")
            setDesc("")
        } catch (error) {
            console.log(error)
        }
    }

    return (
        <form className="announcement-form">
            <div className="top-announcement-form">
                <div className="profile-pic">
                    <img
                        src="https://img.freepik.com/free-photo/portrait-white-man-isolated_53876-40306.jpg?w=900&t=st=1691932082~exp=1691932682~hmac=f10869f2a6b989045fe787063f903e31785f016a5be93ef1194b14e23c31c296"
                        alt=""/>
                </div>
                <input
                    value={title}
                    onChange={e => setTitle(e.target.value)}
                    type="text"
                    placeholder="Announce something to your class"/>
                <div className="send" onClick={handleAnnounce}>
                    Send
                    <LiaPaperPlaneSolid size={30}/>
                </div>
            </div>
            <div className="bottom-announcement-form">
                <textarea
                    placeholder="Description"
                    value={desc}
                    onChange={e => setDesc(e.target.value)}
                    cols="30"
                    rows="10"></textarea>
            </div>
        </form>
    );
}

export default AnnouncementForm