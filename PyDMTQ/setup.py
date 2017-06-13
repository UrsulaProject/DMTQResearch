from setuptools import setup,find_packages
import os,sys,errno
def recursiveSearch(directory):
    return [os.path.join(root, name)
                 for root, dirs, files in os.walk(directory)
                 for name in files
                 if name.endswith(".DS_Store")==False]
setup(
    name='PyDMTQ',
    version='0.0.1',
    packages=find_packages(),
    url = "https://github.com/Naville/DMTQResearch",
    license='GPL',
    author='Naville',
    author_email='admin@mayuyu.io',
    description='Python Interface For DMTQ API',
    install_requires=['pkcs7','PyCrypto',"requests"],
    zip_safe = False,
    include_package_data=True
)
