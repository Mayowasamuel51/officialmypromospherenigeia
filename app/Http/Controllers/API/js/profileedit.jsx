import bgLOGO from "../../../assets/icons/icon2.svg"
import anon from "../../../assets/images/anon.png";
import { useState } from "react";
import { storage } from "../../../../firebase";
import { useStateContext } from "../../../contexts/ContextProvider";
import { FaWhatsapp } from "react-icons/fa";
import {
  ref,
  uploadBytesResumable,
  getDownloadURL,
} from "firebase/storage";
import { toast, Toaster } from 'sonner';
import FetchUser from "../../../hooks/fetchUser";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { XMarkIcon } from "@heroicons/react/24/solid";
import axios from "axios";
import * as Yup from "yup"
import { useFormik } from 'formik';

const api_edit_profile_put_endpoint = import.meta.env.VITE_EDIT_PROFILE_PUT;
const api_backgroundimage = import.meta.env.VITE_EDIT_BACKGROUND;
const api_fetch = import.meta.env.VITE_EDIT_PROFILE;


const ProfileEdit = () => {
  const queryClient = useQueryClient()
  const { token, setToken, darkMode } = useStateContext();
  const [ProfileImageUpload, setProfileImageUpload] = useState(null);
  const [BackgroundImageUpload, setBackgroundImageUpload] = useState(null);
  const [loading, setLoading] = useState(false);
  const [progress, setProgress] = useState(0);

  const { data: profile, isLoading } = FetchUser(token?.user_name);

  const validationSchema = Yup.object({
    aboutMe: Yup.string().notRequired(),
    brandName: Yup.string().notRequired(),
    websiteName: Yup.string().notRequired(),
    user_phone: Yup.string().notRequired(),
    whatapp: Yup.string().notRequired(),
    profile_picture: Yup.mixed().notRequired(),
    background_profile: Yup.mixed().notRequired(),
  });
console.log(token)
  const FORMSUBMIT = async (data, BG) => {
    let payload = {
    
      aboutMe: data.aboutMe,
      brandName: data.brandName,
      websiteName: data.websiteName,
      UserName:data.UserName,
      whatapp: data.whatapp,
      user_phone: data.user_phone,
      messageCompany: "I sell anything good",
    };
    console.log(dirty)
    if (typeof BG === 'string') {
      if (typeof data.profile_picture === 'object') {
        setLoading(true)
        const imageRef = ref(storage, `/profile/${data.profile_picture.name} ${token?.user}`);
        const uploadTask = uploadBytesResumable(imageRef, data.profile_picture);
        uploadTask.on(
          "state_changed",
          (snapshot) => {
            const progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
            setProgress(progress);
            console.log("Upload is " + progress + "% done");
            switch (snapshot.state) {
              case "paused":
                console.log("Upload is paused");
                break;
              case "running":
                console.log("Upload is running");
                break;
            }
          },
          (error) => {
            switch (error.code) {
              case "storage/unauthorized":
                // User doesn't have permission to access the object
                break;
              case "storage/canceled":
                // User canceled the upload
                break;
              // ..
              case "storage/unknown":
                // Unknown error occurred, inspect error.serverResponse
                break;
            }
          },
          async () => {
            const downloadURL = await getDownloadURL(uploadTask.snapshot.ref);
            console.log("these are the images", [downloadURL]);
            payload.profileImage = downloadURL
            const responseTwo = await axios.put(`${api_edit_profile_put_endpoint}${token?.id}`, payload, {
              headers: {
                Accept: "application/json",
                Authorization: `Bearer ${token?.token}`,
              },
            })
            console.log(responseTwo);
            if (responseTwo.data.status === 200) {
              const upd = responseTwo.data.updated
              setToken(prev => {
                const newToken = {
                  ...prev,
                  ...upd
                };
                localStorage.setItem('user-details', JSON.stringify(newToken));
                return newToken;
              });
              setLoading(false)
              setProgress(0);
              toast.success("Your profile has been successfully updated for your client to see ")
              // console.log(token)
              setFieldValue("profile_picture", null);
              queryClient.invalidateQueries(["userPost", token?.user_name])
            } else if (responseTwo.data.status === 500 || responseTwo.data.status === 422) {
              console.log(responseTwo.data.message); console.log(responseTwo.data.errors)
            }
          }
        );
      }
      else {
        setLoading(true)
        payload.profileImage = token?.profileImage
        const responseTwo = await axios.put(`${api_fetch}/${token?.id}`, payload, {
          headers: {
            Accept: "application/json",
            Authorization: `Bearer ${token?.token}`,
          },
          onUploadProgress: (progressEvent) => {
            const total = progressEvent.total;
            const current = progressEvent.loaded;
            const percentage = Math.floor((current / total) * 100);
            setProgress(percentage);
          },
        })
        console.log(responseTwo);
        if (responseTwo.data.status === 200) {
          const upd = responseTwo.data.updated
          setToken(prev => {
            const newToken = {
              ...prev,
              ...upd
            };
            localStorage.setItem('user-details', JSON.stringify(newToken));
            return newToken;
          });
          setLoading(false)
          toast.success("Your profile has been successfully updated for your client")
          setFieldValue("profile_picture", null);
          queryClient.invalidateQueries(["userPost", token?.user_name])
        }
        else if (responseTwo.data.status === 500 || responseTwo.data.status === 422) {
          console.log(responseTwo.data.message);
        }
      }
    }
    else {
      if (typeof data.background_profile === 'object') {
        const imageRef = ref(storage, `/profile/${data.background_profile.name} ${token?.user}`);
        const uploadTask = uploadBytesResumable(imageRef, data.background_profile);
        setLoading(true)
        uploadTask.on(
          "state_changed",
          (snapshot) => {
            const progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
            setProgress(progress);
            console.log("Upload is " + progress + "% done");
            switch (snapshot.state) {
              case "paused":
                console.log("Upload is paused");
                break;
              case "running":
                console.log("Upload is running");
                break;
            }
          },
          (error) => {
            // A full list of error codes is available at
            // https://firebase.google.com/docs/storage/web/handle-errors
            switch (error.code) {
              case "storage/unauthorized":
                // User doesn't have permission to access the object
                break;
              case "storage/canceled":
                // User canceled the upload
                break;
              // ..
              case "storage/unknown":
                // Unknown error occurred, inspect error.serverResponse
                break;
            }
          },
          async () => {
            const downloadURL = await getDownloadURL(uploadTask.snapshot.ref);
            console.log("these is the image", [downloadURL]);
            const payload = {
              backgroundimage: downloadURL,
            };
            try {
              const responseTwo = await axios.put(`${api_backgroundimage}${token?.id}`, payload, {
                headers: {
                  Accept: "application/vnd.api+json",
                  Authorization: `Bearer ${token?.token}`,
                },
              })
              if (responseTwo.data.status === 200) {
                const upd = responseTwo.data.updated
                setToken(prev => {
                  const newToken = {
                    ...prev,
                    ...upd
                  };
                  localStorage.setItem('user-details', JSON.stringify(newToken));
                  return newToken;
                });
                setLoading(false)
                setProgress(0);
                toast.success("Your background image profile has been successfully updated for your client.")
                setFieldValue("background_profile", null);
                queryClient.invalidateQueries(["userPost", token?.user_name])
              } else if (responseTwo.data.status === 500 || responseTwo.data.status === 422) {
                console.log(responseTwo.data.message);
              }
            } catch (error) {
              console.log(error)
              setLoading(false)
            }
          }
        )
      }
      else {
        toast.error('You did not select any background Image')
      }
    }
  }

  const profileMutation = useMutation({
    mutationFn: (data) => FORMSUBMIT(data, data.background_profile),
    onSuccess: () => {
      queryClient.invalidateQueries(["userPost", token?.user_name])
    },
    onError: (error) => {
      toast.error(error.message)
    },
  })

  const { handleChange, handleSubmit, setFieldValue, errors, values, dirty } = useFormik({
    initialValues: {
      profile_picture: profile?.data?.data[0]?.profileImage || '',
      background_profile: profile?.data?.data[0]?.backgroundimage || '',
      aboutMe: profile?.data?.data[0]?.aboutMe || '',
      messageCompany: profile?.data?.data[0]?.messageCompany || '',
      brandName: profile?.data?.data[0]?.brandName || '',
      websiteName: profile?.data?.data[0]?.websiteName || '',
      user_phone: profile?.data?.data[0]?.user_phone || '',
      whatapp: profile?.data?.data[0]?.whatapp || '',
      UserName:profile?.data?.data[0]?.UserName ||''
    },
    validationSchema,
    enableReinitialize: true,
    onSubmit: (values) => {
      profileMutation.mutate(values)
    },
  })

  const cancelImage = (event, setImageUpload, setFieldValue, fieldName) => {
    event.preventDefault();
    setImageUpload(null);
    setFieldValue(fieldName, null);
  }

  const handleImageChange = (event, setImageUpload, setFieldValue, fieldName) => {
    const file = event.currentTarget.files[0];
    if (!file || !file.type.startsWith('image/')) {
      toast.error('Please upload a valid image file');
      return;
    }
    const reader = new FileReader();
    reader.onloadend = () => {
      setImageUpload([reader.result]);
      setFieldValue(fieldName, file);
    };
    reader.readAsDataURL(file);
  };

  return (
    <section className="relative w-full md:px-0 px-2">
      <Toaster position="top-center" />
      {(loading) &&
        <div className="z-[999999999999999] fixed inset-0 bg-black bg-opacity-60 flex flex-col items-center justify-center">
          <div className="">
            <div
              className={`text-black dark:text-white inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-e-transparent align-[-0.125em] text-surface motion-reduce:animate-[spin_1.5s_linear_infinite]`}
              role="status">
              <span
                className="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
              >Loading...</span>
            </div>
          </div>
          <div className="md:hidden block w-1/2 bg-gray-200 rounded-full h-2 mt-3">
            <div
              className="bg-blue h-2 rounded-lg"
              style={{ width: `${progress}%` }}
            ></div>
          </div>
          <p className="md:hidden block text-white mt-2">{Math.round(progress)}%</p>
        </div>
      }
      <header>
        <h3 className="font-600 md:text-xl text-xl jost md:text-left text-right">Edit Profile</h3>
        <p className="font-400 text-sm my-2">Set up your presence and hiring needs</p>
      </header>
      {isLoading &&
        <div className="min-h-screen grid place-content-center">
          <div
            className="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-e-transparent align-[-0.125em] text-surface motion-reduce:animate-[spin_1.5s_linear_infinite] dark:text-white"
            role="status">
            <span
              className="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
            >Loading...</span>
          </div>
        </div>
      }
      {!isLoading &&
        <article className="">
          <h1 className="font-medium my-2 text-sm">👇Click to changeBackgrond Image</h1>
          <form onSubmit={handleSubmit} encType="multipart/form-data" className="flex items-center gap-4">
            <article className="flex items-center">
              <div>
                {BackgroundImageUpload ? (
                  <div className="relative">
                    <img
                      src={BackgroundImageUpload}
                      alt="Background-photo"
                      className="w-[80px] aspect-square rounded-full object-cover"
                      name="background_profile"
                      id="background_profile"
                    />
                    <div onClick={(e) => cancelImage(e, setBackgroundImageUpload, setFieldValue, "background_profile")} className="bg-white absolute w-10 aspect-square flex justify-center items-center rounded-full border right-3 top-4">
                      <XMarkIcon width={20} />
                    </div>
                  </div>
                ) : (
                  <label htmlFor="background_profile">
                    <img
                      src={profile?.data?.data[0]?.backgroundimage ? profile?.data?.data[0]?.backgroundimage : bgLOGO}
                      alt="blankImage"
                      className="w-[80px] aspect-square rounded-full border duration-200 hover:scale-110 cursor-pointer object-cover"
                    />
                  </label>
                )}
                <div className="flex gap-x-[.5rem] items-center">
                  <button className="cursor-pointer">
                    <input
                      type="file"
                      onChange={(e) => handleImageChange(e, setBackgroundImageUpload, setFieldValue, 'background_profile')}
                      className="cursor-pointer hidden"
                      name="background_profile"
                      id="background_profile"
                    />
                  </button>
                </div>
              </div>
            </article>
            <button type="submit"
              className="bg-purple py-3 px-3 md:py-3 md:px-4 text-white rounded-md my-2 text-sm md:text-base">
              Change Backgorund Image
            </button>
          </form>
          <hr className="my-4" />
          <form onSubmit={handleSubmit}>
            <article className="flex items-center">
              <div>
                {ProfileImageUpload ? (
                  <div className="relative">
                    <img
                      src={ProfileImageUpload}
                      alt="profilephoto"
                      className="w-[80px] aspect-square rounded-full object-cover"
                      name="profile_picture"
                      id="profile_picture"
                    />
                    <div onClick={(e) => cancelImage(e, setProfileImageUpload, setFieldValue, "profile_picture")} className="bg-white absolute w-10 aspect-square flex justify-center items-center rounded-full border right-3 top-4">
                      <XMarkIcon width={20} />
                    </div>
                  </div>
                ) : (
                  <label htmlFor="profile_picture" className="relative">
                    <img
                      src={profile?.data?.data[0]?.profileImage ? profile?.data?.data[0]?.profileImage : anon}
                      alt="blank-Image"
                      className="w-[80px] aspect-square rounded-full object-cover border duration-200 hover:scale-110 cursor-pointer"
                    />
                  </label>
                )}
                <div className="flex gap-x-[.5rem] items-center">
                  <button className="relative cursor-pointer">
                    <input
                      type="file"
                      className="cursor-pointer hidden"
                      onChange={(e) => handleImageChange(e, setProfileImageUpload, setFieldValue, 'profile_picture')}
                      name="profile_picture"
                      id="profile_picture"
                    />
                  </button>
                </div>
              </div>
            </article>
            <div className="flex flex-col gap-5 my-4">
            <div className="">
                <div className="flex flex-col gap-2">
                  <label htmlFor="About" className="jost font-semibold">
                    Create your username 
                  </label>
                  <input
                    type="text"
                    value={values.UserName}
                    onChange={handleChange}
                    name="UserName"
                    id="UserName"
                    className={`w-full ${darkMode ? "bg-DARKBG dark:bg-DARKBG dark:placeholder:text-mainTextDark placeholder:text-mainTextDark" : "bg-slate-100 dark:bg-slate-100 placeholder:text-black dark:placeholder:text-black"} focus:outline focus:outline-2 focus:outline-purple w-[100%] focus:outline-none p-3 jost rounded-sm`}
                    placeholder="create your username"
                  />
                  <p className='text-red text-sm'>{errors.aboutMe?.message}</p>
                </div>
              </div>


              <div className="">
                <div className="flex flex-col gap-2">
                  <label htmlFor="About" className="jost font-semibold">
                    About
                  </label>
                  <textarea
                    type="text"
                    onChange={handleChange}
                    value={values.aboutMe}
                    name="aboutMe"
                    id="aboutMe"
                    className={`w-full resize-none h-32 ${darkMode ? "bg-DARKBG dark:bg-DARKBG dark:placeholder:text-mainTextDark placeholder:text-mainTextDark" : "bg-slate-100 dark:bg-slate-100 placeholder:text-black dark:placeholder:text-black"} focus:outline focus:outline-2 focus:outline-purple  w-[100%] focus:outline-none p-3 jost rounded-sm placeholder:text-black`}
                    placeholder="Tell Us About You"
                  ></textarea>
                  <p className='text-red text-sm'>{errors.aboutMe?.message}</p>
                </div>
              </div>
              <div className="">
                <div className="flex flex-col gap-2">
                  <label htmlFor="website" className="jost font-semibold">
                    Website
                  </label>
                  <input
                    type="url"
                    value={values.websiteName}
                    onChange={handleChange}
                    name="websiteName"
                    id="websiteName"
                    className={`w-full ${darkMode ? "bg-DARKBG dark:bg-DARKBG dark:placeholder:text-mainTextDark placeholder:text-mainTextDark" : "bg-slate-100 dark:bg-slate-100 placeholder:text-black dark:placeholder:text-black"} focus:outline focus:outline-2 focus:outline-purple w-[100%] focus:outline-none p-3 jost rounded-sm`}
                    placeholder="Add your whatsapp or website link here"
                  />
                  {/* <p className='text-red  text-sm'>{errors.websiteName?.message}</p> */}
                </div>
              </div>
              <div className="flex flex-col gap-2">
                <label htmlFor="website" className="jost font-semibold flex items-center gap-2">
                  <p>Contact phone Number</p><div><FaWhatsapp size={20} color="green" /></div>
                </label>
                <input
                  value={values.user_phone}
                  onChange={handleChange}
                  type="text"
                  name="user_phone"
                  id="user_phone"
                  className={`w-full ${darkMode ? "bg-DARKBG dark:bg-DARKBG dark:placeholder:text-mainTextDark placeholder:text-mainTextDark" : "bg-slate-100 dark:bg-slate-100 placeholder:text-black dark:placeholder:text-black"} focus:outline focus:outline-2 focus:outline-purple dark:placeholder:text-smallTextDark w-full focus:outline-none p-3 jost rounded-sm placeholder:text-black`}
                  placeholder="Enter your Contact number " />
                {/* <p className='text-red  text-sm'>{errors.brandName?.message}</p> */}
              </div>

              {/* <div className="flex flex-col gap-2">
                <label htmlFor="website" className="jost font-semibold flex items-center gap-2">
                  <p>Contact Two</p><div><FaWhatsapp size={20} color="green" /></div>
                </label>
                <input
                  value={values.whatapp}
                  onChange={handleChange}
                  type="number"
                  name="whatapp"
                  id="whatsapp"
                  className={`${darkMode ? "bg-DARKBG dark:bg-DARKBG dark:placeholder:text-mainTextDark placeholder:text-mainTextDark" : "bg-slate-100 dark:bg-slate-100 placeholder:text-black dark:placeholder:text-black"} focus:outline focus:outline-2 focus:outline-purple dark:placeholder:text-smallTextDark w-full focus:outline-none p-3 jost rounded-sm placeholder:text-black`}
                  placeholder="Enter Your  Whatapp number" />
              </div> */}
              <div className="flex flex-col gap-2">
                <label htmlFor="website" className="jost font-semibold">
                  Brand Name
                </label>{" "}
                <input
                  value={values.brandName}
                  onChange={handleChange}
                  type="text"
                  name="brandName"
                  id="brandName"
                  className={`w-full ${darkMode ? "bg-DARKBG dark:bg-DARKBG dark:placeholder:text-mainTextDark placeholder:text-mainTextDark" : "bg-slate-100 dark:bg-slate-100 placeholder:text-black dark:placeholder:text-black"} focus:outline focus:outline-2 focus:outline-purple dark:placeholder:text-smallTextDark w-full focus:outline-none p-3 jost rounded-sm placeholder:text-black`}
                  placeholder="Enter Your Brand Name" />
                {/* <p className='text-red  text-sm'>{errors.brandName?.message}</p> */}
              </div>
            </div>
            <button
              type="submit"
              disabled={profileMutation.isLoading || !dirty}
              className={`border ${dirty ? "bg-purple border-purple hover:text-purple" : "bg-red border-red hover:text-red cursor-not-allowed"} py-2 md:py-4 capitalize w-full text-white rounded-md mt-2 duration-300 hover:bg-transparent`}>
              Update
            </button>
          </form>
        </article>}
    </section>
  );
};

export default ProfileEdit;